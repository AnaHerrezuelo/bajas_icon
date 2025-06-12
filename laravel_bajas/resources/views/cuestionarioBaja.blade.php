
@extends('layouts.bajasTemplate')


@section('content')
<div id="content">
    <a href="/index" type="button" class="bt1"> Volver </a>
    <h1> Nueva Baja</h1>
    @if($errors->any())
        <div id="errors">
            @foreach($errors->all() as $error)
                <p>  {{ $error }} </p>
            @endforeach
        </div>
    @endif
    <form action="/insertarBaja" method="POST" class="form">
        @csrf
        <label for="fecha_inicio"> Fecha de Inicio </label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio') }}" required>

        <br>
        <label for="fecha_fin"> Fecha de Fin </label>
        <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin') }}"required>

        <br>
        <label for="motivo"> Motivo </label>
        <input type="text" id="motivo" name="motivo" value="{{ old('motivo') }}" required>

        <br>
        <label for="comentario"> Comentario </label>
        <input type="text" id="comentario" name="comentario" value="{{ old('comentario') }}">
        
        <br>

        <label for="trabajador"> DNI de Trabajador </label>
        <input type="text" id="trabajador" name="trabajador" value="{{ old('trabajador') }}" placeholder="Ex: 12345678A">

        <br>
        <br>
        <button type="submit" class="bt1"> Insertar Baja </button>
    </form>
    <br> 
</div>
@endsection
