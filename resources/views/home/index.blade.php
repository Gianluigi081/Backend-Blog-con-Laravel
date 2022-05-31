@extends('layouts.base')

@section('styles')
<link href="{{ asset('css/manage_post/categories/css/article_category.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'Blog')

@section('content')

@include('layouts.navbar')

<div class="slogan">
    <div class="column1">
        <h2>BLOG</h2>
    </div>
    <div class="column2">
        <p>Hemos ayudado a más de 1 millon de personas a crecer 
           profesionalmente. Estos artículos comparten concejos
           para la búsqueda de empleo, la productividad y el éxito 
           laboral en diferentes áreas del conocimiento.</p>
    </div>
</div>

<div class="article-container">
    <!-- Listar artículos -->
    @foreach ($articles as $article)
        
    <article class="article">
        <img src="{{ $article->image }}" class="img">
        <div class="card-body">
            <a href="{{ route('articles.show', $article->slug) }}">
                <h2 class="title">{{ Str::limit($article->title, 60, '...') }}</h2>
            </a>
            <p class="introduction">{{ Str::limit($article->introduction, 100, '...') }}</p>
        </div>
    </article>
    @endforeach
</div>
<div class="links-paginate"> 
    {{ $articles->links() }}
</div>
@endsection