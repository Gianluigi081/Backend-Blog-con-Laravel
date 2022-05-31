@extends('adminlte::page')

@section('title', 'Panel de administración')

@section('content_header')
<h2>Administra los comentarios</h2>
@endsection

@section('content')

@if(session('success-delete'))
<div class="alert alert-info">
    {{ session('success-delete') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Título del artículo</th>
                    <th>Calificación⭐</th>
                    <th>Comentario</th>
                    <th>Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
              @foreach($comments as $comment)
                <tr>
                    <td>{{ $comment->title }}</td>
                    <td>{{ $comment->value }}</td>
                    <td>{{ $comment->description }}</td>
                    <td>{{ $comment->full_name }}</td>

                    <td width="10px">
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Eliminar" class="btn btn-danger btn-sm">
                        </form>
                    </td>
                    @endforeach
            </tbody>
    </div>
</div>
@endsection