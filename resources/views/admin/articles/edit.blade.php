@extends('adminlte::page')

@section('title', 'Modificar artículo')

@section('content_header')
<h2>Modificar artículo</h2>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('articles.update', $article) }}" enctype="multipart/form-data">
            @csrf 
            @method('PUT')

            <div class="form-group">
            <input type="hidden" name="id" value="{{ $article->id }}">
            </div>

            <div class="form-group">
                <label>Título</label>
                <input type="text" class="form-control" id="title" name='title' minlength="5" 
                maxlength="255" value="{{ $article->title }}">

                @error('title')    
                <span class="text-danger">
                    <span>*{{ $message }}</span>
                </span>
                @enderror
                
            </div>

            <div class="form-group">
                <label for="">Slug</label>
                <input type="text" class="form-control" id="slug" name='slug' 
                placeholder="Slug del artículo" readonly value="{{ $article->slug }}">
 
                @error('slug')    
                <span class="text-danger">
                    <span>* {{ $message }}</span>
                </span>
                @enderror
                
            </div>

            <div class="form-group">
                <label>Introducción</label>
                <input type="text" class="form-control" id="introduction" name='introduction' 
                minlength="5" maxlength="255" value="{{ $article->introduction }}">
       
                @error('introduction')    
                <span class="text-danger">
                    <span>* {{ $message }}</span>
                </span>
                @enderror
               
            </div>

            <div class="form-group">
                <label>Cambiar imagen</label>
                <input type="file" class="form-control-file mb-2" id="image" name='image'>

                <div class="rounded mx-auto d-block">
                    <img src="{{ $article->image }}" style="width: 250px">
                </div>

                @error('image')    
                <span class="text-danger">
                    <span>* {{ $message }}</span>
                </span>
                @enderror
             
            </div>


            <div class="form-group">
                <label for="">Desarrollo del artículo</label>
                <textarea class="ckeditor form-control" id="body" name="body">{{ $article->body }}</textarea>             

                @error('body')    
                <span class="text-danger">
                    <span>*{{ $message }}</span>
                </span>
                @enderror
                
            </div>

            <label>Estado</label>
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">Privado</label>
                    <input class="form-check-input ml-2" type="radio" name='status' id="status" value="0"
                    {{ ($article->status == 0) ? 'checked' : ''}}>
                </div>

                <div class="form-check form-check-inline">
                    <label class="form-check-label">Público</label>
                    <input class="form-check-input ml-2" type="radio" name='status' id="status" value="1"
                    {{ ($article->status == 1) ? 'checked' : ''}}>
                </div>

                @error('status')    
                <span class="text-danger">
                    <span>* {{ $message }}</span>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <select class="form-control" name="category_id" id="category_id">
                    <option>Seleccione una categoría</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $article->category_id == $category->id ? 'selected' : ''  }}>
                    {{ $category->name }}
                    </option>
                    @endforeach
                </select>

                @error('category_id')
                <span class="text-danger">
                    <span>*{{ $message }}</span>
                </span>
                @enderror
                
            </div>
            <input type="submit" value="Modificar artículo" class="btn btn-primary">
        </form>
    </div>
</div>
@endsection

@section('js')

<script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

<script src="{{ asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js') }}"></script>

<script>
    $(document).ready( function() {
    $("#title").stringToSlug({
        setEvents: 'keyup keydown blur',
        getPut: '#slug',
        space: '-'
    });
    });
</script>
@endsection