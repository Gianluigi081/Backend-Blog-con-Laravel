@extends('adminlte::page')

@section('title', 'Panel de administración')

@section('content_header')
    <h1>Modificar Rol</h1>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('roles.update', $role->id)}}">
            @csrf 
            @method('PUT')
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" class="form-control" id="name" name='name' placeholder="Nombre del rol"
                    value="{{ $role->name }}">

                @error('name')
                <span class="alert-red">
                    <span>*{{ $message }}</span>
                </span>
                @enderror
            </div>
            <h3>Lista de permisos</h3>
            @foreach($permissions as $permission)
            <div>
                <label>
                    <input type="checkbox" name="permissions[]" id="" 
                    value="{{ $permission->id }}" 
                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : ''}}
                    class="mr-1">
                    
                    {{ $permission->description }}
                    
                </label>
            </div>
            @endforeach

            <input type="submit" value="Modificar rol" class="btn btn-primary">
        </form>
    </div>
</div>

@endsection
