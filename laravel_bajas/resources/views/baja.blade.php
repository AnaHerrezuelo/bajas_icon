
@extends('layouts.bajasTemplate')

@section('header')
<header>
    <nav><h1>navegador</h1></nav>
</header>
@endsection

@section('content')
<div id="content">
        <td> <a href="/index" type="button" class="bt1"> Página Principal </a></td>
    <h1> Baja {{$id_baja}}</h1>
        <table>
        <thead>
            <tr>
                <th> Estado </th>
                <th> Fecha_inicio </th>
                <th> Fecha_fin</th>
                <th> Duración </th>
                <th> Motivo </th>
                <th> Comentario</th>
                <th> Trabajador</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td> 
                    @if($bajaEsp -> estado == 1)
                        Activo @else 
                        Inactivo
                    @endif 
                </td>
                <td>{{ Carbon\Carbon::parse($bajaEsp->fecha_inicio)->format('d-m-Y') }}</td>
                <td>{{ Carbon\Carbon::parse($bajaEsp->fecha_fin)->format('d-m-Y') }}</td>
                <td> {{ $bajaEsp -> duracion }}</td>
                <td> {{ $bajaEsp -> motivo}}</td>
                <td> {{ $bajaEsp -> comentario}}</td>
                <td> {{ $bajaEsp -> bajas_fk1 -> nombre}}</td>
            </tr>

        </tbody>
    </table>
</div>

<br><br>
@endsection