@extends('adminlte::page')

@section('title', 'Panel de administración')

@section('content_header')
<h1>Administra los roles</h1>
@endsection

@section('content')

@if(session('success-create'))
<div class="alert alert-info">
    {{ session('success-create') }}
</div>
@elseif(session('success-update'))
<div class="alert alert-info">
    {{ session('success-update') }}
</div>
@elseif(session('success-delete'))
<div class="alert alert-info">
    {{ session('success-delete') }}
</div>
@endif


<div class="card">
    <div class="card-header">
        <a class="btn btn-primary" href="{{ route('roles.create') }}">Crear rol</a>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>

                    <td width="10px"><a href="{{ route('roles.edit', $role) }}" class="btn btn-primary btn-sm mb-2">Editar</a></td>

                    <td width="10px">
                        <form action="{{ route('roles.destroy', $role) }}" method="POST">  
                            @csrf
                            @method('DELETE')  
                            <input type="submit" value="Eliminar" class="btn btn-danger btn-sm">
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

