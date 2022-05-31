<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ArticleRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ArticleController extends Controller
{
    //Proteger las rutas
    public function __construct()
    {
        $this->middleware('can:articles.index')->only('index');
        $this->middleware('can:articles.create')->only('create', 'store');
        $this->middleware('can:articles.edit')->only('edit', 'update');
        $this->middleware('can:articles.destroy')->only('destroy');
    }

    public function index()
    {
        //Mostrar los artículos en el admin
        $user = Auth::user();
        $articles = Article::where('user_id', $user->id)
                    ->orderBy('id', 'desc')
                    ->simplePaginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        //Obtener categorías públicas
        $categories = Category::select(['id', 'name'])
                                ->where('status', '1')
                                ->get();

        return view('admin.articles.create', compact('categories'));
    }

    public function store(ArticleRequest $request)
    {   

        $request->merge([
            'user_id' => Auth::user()->id,
        ]);

        //Guardo la solicitud en una variable
        $article = $request->all();

        //Validar si hay un archivo en el request
        if($request->hasFile('image')){
            $article['image'] = Cloudinary::upload($request->file('image')
            ->getRealPath(),[
               'folder' => 'Articles', 
            ])->getSecurePath();
        }

        Article::create($article);

        return redirect()->action([ArticleController::class, 'index'])
                            ->with('success-create', 'Artículo creado con éxito');

    }

    public function show(Article $article)
    {
        $this->authorize('published', $article);

        $comments = $article->comments()->simplePaginate(5);

        return view('subscriber.articles.show', compact('article', 'comments'));
    }

    public function edit(Article $article)
    {
        $this->authorize('view', $article);

        //Obtener categorías públicas
        $categories = Category::select(['id', 'name'])
                                ->where('status', '1')
                                ->get();

        return view('admin.articles.edit', compact('categories', 'article'));
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $this->authorize('update', $article);

        //Obtener la imagen actual
        $current_image = $article->image; 
        //Dividir url cada vez que encuentre un /
        $split_url = explode('/', $current_image);
        /* Obtener la última posición y separar cuando encuentre un punto 
        esto lo hacemos para quitar la extensión jpg, png, etc y que quede
        el public id 
        */
        $public_id = explode('.', $split_url[sizeof($split_url)-1]);

        //Si el usuario sube una nueva imagen
        if($request->hasFile('image')){

            //Eliminar la imagen anterior
            Cloudinary::destroy('Articles/'.$public_id[0]);

            //Asigna la nueva imagen
            $article['image'] = Cloudinary::upload($request->file('image')
            ->getRealPath(),[
               'folder' => 'Articles', 
            ])->getSecurePath();
        }

        //Actualizar datos
        $article->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'introduction' => $request->introduction,
            'body' => $request->body,
            'user_id' => Auth::user()->id,
            'category_id' => $request->category_id,
            'status' => $request->status,
        ]);

        return redirect()->action([ArticleController::class, 'index'])
                            ->with('success-update', 'Artículo modificado con éxito');
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        $current_image = $article->image;
        $split_url = explode('/', $current_image);
        $public_id = explode('.', $split_url[sizeof($split_url)-1]); 

        //Eliminar imagen del artículo
        if($article->image){
            Cloudinary::destroy('Articles/'.$public_id[0]);
        }

        //Eliminar artículo
        $article->delete();

        return redirect()->action([ArticleController::class, 'index'], compact('article'))
            ->with('success-delete', 'Artículo eliminado con éxito');
    }
}
