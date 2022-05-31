@extends('adminlte::page')

@section('title', 'Crear categoría')

@section('content_header')
<h2>Crear Nueva Categoría</h2>
@endsection

@section('content') 

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="">Nombre</label>
                <input type="text" class="form-control" id="name" name='name' placeholder="Nombre de la categoría" 
                 value="{{ old('name') }}">

                @error('name')
                <span class="text-danger">
                    <span>*{{ $message }}</span>
                </span>
                @enderror
            </div>


            <div class="form-group">
                <label for="">Slug</label>
                <input type="text" class="form-control" id="slug" name='slug' placeholder="Slug de la categoría" readonly
                    value="{{ old('slug') }}">

                @error('slug')
                <span class="text-danger">
                    <span>*{{ $message }}</span>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="">Subir imagen</label>
                <input type="file" class="form-control-file" id="image" name='image'>

                @error('image')
                <span class="text-danger">
                    <span>*{{ $message }}</span>
                </span>
                @enderror
            </div>


            <label for="">Estado</label>
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="">Privado</label>
                    <input class="form-check-input ml-2" type="radio" name='status' id="status" value="0" checked>
                </div>

                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="">Público</label>
                    <input class="form-check-input ml-2" type="radio" name='status' id="status" value="1">
                </div>

                @error('status')
                <span class="text-danger">
                    <span>*{{ $message }}</span>
                </span>
                @enderror
            </div>

            <label for="">Destacado</label>
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">No</label>
                    <input class="form-check-input ml-2" type="radio" name='is_featured' id="is_featured" value="0"
                        checked>
                </div>

                <div class="form-check form-check-inline">
                    <label class="form-check-label">Si</label>
                    <input class="form-check-input ml-2" type="radio" name='is_featured' id="is_featured" value="1">
                </div>

                @error('is_featured')
                <span class="text-danger">
                    <span>*{{ $message }}</span>
                </span>
                @enderror

            </div>
            <input type="submit" value="Crear categoría" class="btn btn-primary">
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js') }}"></script>

<script>
    $(document).ready( function() {
    $("#name").stringToSlug({
        setEvents: 'keyup keydown blur',
        getPut: '#slug',
        space: '-'
    });
    });
</script>
@endsection