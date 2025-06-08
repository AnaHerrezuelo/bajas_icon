@extends('layouts.bajasTemplate')


@section('header')
<header>
    <nav><h1>navegador</h1></nav>
</header>
@endsection

@section('content')       
    <div id="content">
        <h1> Bajas Activas </h1>
        <a href="/cuestionarioBaja" type="button" class="bt1"> Insertar Baja </a>
        <br><br>
            <table>
                <thead>
                    <tr>
                        <th> estado </th>
                        <th> duración </th>
                        <th> Motivo </th>
                        <th> Trabajador</th>
                        <th> Ver baja</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datosBajasActivas as $dato)
                    <tr>
                        <!-- <td> {{ $dato->estado }} </td> 
                        <td> 
                            @if($dato->estado == 1)
                                Activo @else Inactivo
                            @endif 
                        </td>
                        -->

                        @if($dato->estado == 1)
                            <td style="background-color: rgba(142, 250, 148, 0.5);"> 
                                Activo
                            </td>
                        @else 
                            <td style="background-color: rgba(255, 146, 146, 0.57);">
                                Inactivo
                            </td>
                        @endif 

                        <td> {{$dato->duracion}}</td>
                        <td>{{ $dato->motivo }}</td>
                        <td>{{$dato->bajas_fk1->nombre}}, {{$dato->bajas_fk1->apellido1}}  </td>
                        <!-- <td> <a href="/mostrarBaja" type="button"> Ver Detalles </a></td> -->
                        <td> <a href="/baja/{{ $dato->id_baja }}" type="button" class="bt1"> Ver Detalles </a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            <h1> Todas las bajas </h1>
            <table>
                <thead>
                    <tr>
                        <th> estado </th>
                        <th> duración </th>
                        <th> Motivo </th>
                        <th> Trabajador</th>
                        <th> Ver baja</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datosBajasTodas as $dato)
                    <tr>
                        @if($dato->estado == 1)
                            <td style="background-color: rgba(142, 250, 148, 0.5);"> 
                                Activo
                            </td>
                        @else 
                            <td style="background-color: rgba(255, 146, 146, 0.57);">
                                Inactivo
                            </td>
                        @endif 

                        <td> {{$dato->duracion}}</td>
                        <td>{{ $dato->motivo }}</td>
                        <td>{{$dato->bajas_fk1->nombre}}, {{$dato->bajas_fk1->apellido1}}  </td>
                        <!-- <td> <a href="/mostrarBaja" type="button"> Ver Detalles </a></td> -->
                        <td> <a href="/baja/{{ $dato->id_baja }}" type="button" class="bt1"> Ver Detalles </a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            
    </div>
@endsection <!-- end body -->