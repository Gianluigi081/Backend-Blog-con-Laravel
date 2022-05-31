<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        #Obtener los artículos públicos (1)
        $articles = Article::where('status', '1')
                    ->orderBy('id', 'desc')
                    ->simplePaginate(10);
        
        #Obtener las categorías con estado público (1) y destacadas (1)
        $navbar = Category::where([
            ['status', '1'],
            ['is_featured', '1'],
        ])->paginate(3);            

        return view('home.index', compact('articles', 'navbar'));
    }

    //Todas las categorías
    public function all(){
        $categories = Category::where('status', '1')
            ->simplePaginate(20);

        #Obtener las categorías con estado público (1) y destacadas (1)
        $navbar = Category::where([
            ['status', '1'],
            ['is_featured', '1'],
        ])->paginate(3);  
        
        return view('home.all-categories', compact('categories', 'navbar'));
    }
}
