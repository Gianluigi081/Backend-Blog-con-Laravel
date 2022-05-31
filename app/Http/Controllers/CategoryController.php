<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use App\Http\Requests\CategoryRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CategoryController extends Controller
{

    //Proteger rutas
    public function __construct()
    {
        $this->middleware('can:categories.index')->only('index');
        $this->middleware('can:categories.create')->only('create', 'store');
        $this->middleware('can:categories.edit')->only('edit', 'update');
        $this->middleware('can:categories.destroy')->only('destroy');
    }

    public function index()
    {
        //Mostrar categorías en el admin
        $categories = Category::orderBy('id', 'desc')
                            ->simplePaginate(8);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        $category = $request->all();

        //Validar si hay un archivo
        if($request->hasFile('image')){

            $category['image'] = Cloudinary::upload($request->file('image')
            ->getRealPath(),[
                'folder' => 'Categories',
            ])->getSecurePath();
        }

        //Guardar información
        Category::create($category);

        return redirect()->action([CategoryController::class, 'index'])
            ->with('success-create', 'Categoría creada con éxito');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {

        $current_image = $category->image;
        $split_url = explode('/', $current_image);
        $public_id = explode('.', $split_url[sizeof($split_url)-1]);

        if($request->hasFile('image')){
            //Eliminar imagen anterior
            Cloudinary::destroy('Categories/'.$public_id[0]);

            //Asignar nueva imagen
            $category['image'] = Cloudinary::upload($request->file('image')
            ->getRealPath(),[
                'folder' => 'Categories',
            ])->getSecurePath();
        }

        //Actualizar datos
        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
            'is_featured' => $request->is_featured,
        ]);

        return redirect()->action([CategoryController::class, 'index'], compact('category'))
            ->with('success-update', 'Categoría modificada con éxito');
    }

    public function destroy(Category $category)
    {

        $current_image = $category->image;
        $split_url = explode('/', $current_image);
        $public_id = explode('.', $split_url[sizeof($split_url)-1]);

        //Eliminar imagen de la categoría
        if($category->image){
            Cloudinary::destroy('Categories/'.$public_id[0]);
        }

        $category->delete();

        return redirect()->action([CategoryController::class, 'index'], compact('category'))
            ->with('success-delete', 'Categoría eliminada con éxito');
    }

    //Filtrar artículos por categorías
    public function detail(Category $category){

        $this->authorize('published', $category);

        $articles = Article::where([
            ['category_id', $category->id],
            ['status', '1']
        ])
            ->orderBy('id', 'desc')
            ->simplePaginate(5);
        
        $navbar = Category::where([
            ['status', '1'],
            ['is_featured', '1'],
        ])->paginate(3);     

        return view('subscriber.categories.detail', compact('articles', 'category', 'navbar'));
    }
}
