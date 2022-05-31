<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;

//Principal
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/all', [HomeController::class, 'all'])->name('home.all');

//Administrador
Route::get('/admin', [AdminController::class, 'index'])
                    ->middleware('can:admin.index')
                    ->name('admin.index');

//Rutas del admin
Route::namespace('App\Http\Controllers')->prefix('admin')->group(function() {

    //Artículos
    Route::resource('articles', 'ArticleController')
                ->except('show')
                ->names('articles');

    
    //Categorías
    Route::resource('categories', 'CategoryController')
                ->except('show')
                ->names('categories');

    //Comentarios
    Route::resource('comments', 'CommentController')
                ->only('index', 'destroy')
                ->names('comments'); 

    //Usuarios
    Route::resource('users', 'UserController')
                ->except('create', 'store', 'show')
                ->names('users');   

    //Roles
    Route::resource('roles', 'RoleController')
                ->except('show')
                ->names('roles');            
});

  

//Perfiles
Route::resource('profiles', ProfileController::class)
                ->only('edit', 'update')
                ->names('profiles');

//Ver artículos
Route::get('article/{article}', [ArticleController::class, 'show'])->name('articles.show');                

//Ver artículos por categorías
Route::get('category/{category}', [CategoryController::class, 'detail'])->name('categories.detail');

//Guardar comentarios
Route::post('/comment', [CommentController::class, 'store'])->name('comments.store');

Auth::routes();


/*
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index'); 
Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create'); 
Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store'); 

Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
*/