@extends('layouts.base')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/login/css/reset.css') }}">
@endsection

@section('content')

<form method="POST" class="form" action="{{ route('password.email') }}">
   @csrf
    <h2 class="reset-title">Restablecer tu contraseña</h2>
    <p class="alert-send">Escribe tu correo electrónico y te enviaremos las
        instrucciones para restablecer tu contraseña</p>

    <div class="content-reset">
        <input class="form-control" id="email" type="email" name="email" 
        value="{{ old('email') }}" required>

        @error('email')
        <span class="text-danger">
            *{{ $message }}
        </span>
        @enderror
    </div>
    
    <input type="submit" value="Enviar" class="button">

    @if(session('status'))
    <div class="reminder">
        <p class="alert-send">{{ session('status') }}</p>
    </div>
    @endif
</form>

@endsection