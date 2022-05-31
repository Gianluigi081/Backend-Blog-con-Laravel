<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{

    //Proteger rutas
    public function __construct()
    {
        $this->middleware('can:comments.index')->only('index');
        $this->middleware('can:comments.destroy')->only('destroy');
    }

    public function index()
    {
        $comments = DB::table('comments')
                ->join('articles', 'comments.article_id', '=', 'articles.id')
                ->join('users', 'comments.user_id', '=', 'users.id')
                ->select('comments.id','comments.value', 'comments.description',
                'articles.title', 'users.full_name')
                ->where('articles.user_id', '=', Auth::user()->id)
                ->orderBy('articles.id', 'desc')
                ->get();
        
        return view('admin.comments.index', compact('comments'));
    }


    public function store(CommentRequest $request)
    {
        //Verificar si en el artículo ya existe un comentario del usuario
        $result = Comment::where('user_id', Auth::user()->id)
                            ->where('article_id', $request->article_id)->exists();

        //Consulta para obtener el slug y estado del artículo comentado
        $article = Article::select('status', 'slug')->find($request->article_id);

        //Si no existe y si el estado del artículo es público, comentar. 
        if(!$result and $article->status == 1){
            Comment::create([
                'value' => $request->value,
                'description' => $request->description,
                'user_id' => Auth::user()->id,
                'article_id' =>  $request->article_id,
            ]);
            return redirect()->action([ArticleController::class, 'show'], [$article->slug]);
        }else{
            return redirect()->action([ArticleController::class, 'show'], [$article->slug])
                             ->with('success-error', 'Solo puedes comentar una vez');;
        }
    }


    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->action([CommentController::class, 'index'], compact('comment'))
            ->with('success-delete', 'Comentario eliminado con éxito');
    }
}
