
@extends('layouts.bajasTemplate')

@section('content')
<div id="content">
    <a href="/index" type="button" class="bt1"> Página Principal </a>
    <h1> Baja  de {{ $bajaEsp -> bajas_fk1 -> nombre}}, {{ $bajaEsp -> bajas_fk1 -> apellido1}} {{ $bajaEsp -> bajas_fk1 -> apellido2}}</h1>
        <table>
        <thead>
            <tr>
                <th> Estado </th>
                <th> Fecha_inicio </th>
                <th> Fecha_fin</th>
                <th> Duración </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @if($bajaEsp->estado == 1 && $bajaEsp->fecha_inicio <= $fechaActual)
                    <td style="background-color: rgba(142, 250, 148, 0.5);"> 
                        Activo
                    </td>
                @elseif($bajaEsp->estado == 1 && $bajaEsp->fecha_inicio > $fechaActual)
                    <td style="background-color: rgba(255, 253, 146, 0.57);">
                        Pendiente
                    </td>
                @else 
                    <td style="background-color: rgba(255, 146, 146, 0.57);">
                        Inactivo
                    </td>
                @endif
                
                <td>{{ Carbon\Carbon::parse($bajaEsp->fecha_inicio)->format('d-m-Y') }}</td>
                <td>{{ Carbon\Carbon::parse($bajaEsp->fecha_fin)->format('d-m-Y') }}</td>
                <td> {{ $bajaEsp -> duracion }}</td>
            </tr>

        </tbody>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <th> Motivo </th>
                <th> Comentario</th>
                <th> Trabajador</th>
                <th> DNI </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td> {{ $bajaEsp -> motivo}}</td>
                <td> {{ $bajaEsp -> comentario}}</td>
                <td> {{ $bajaEsp -> bajas_fk1 -> nombre}}, {{ $bajaEsp -> bajas_fk1 -> apellido1}} {{ $bajaEsp -> bajas_fk1 -> apellido2}}</td>
                <td> {{$bajaEsp -> bajas_fk1 -> dni }}</td>
            </tr>

        </tbody>
    </table>
    <br>
    @if($bajaEsp -> cancelada == 1)
    <p> Esta baja ha sido cancelada el {{ Carbon\Carbon::parse($bajaEsp->updated_At)->format('d-m-Y') }} </p>
    @else 
    
     @endif 
</div>

<br><br>
@endsection