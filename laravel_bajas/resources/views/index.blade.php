@extends('layouts.bajasTemplate')



@section('content')       
    <div id="content">
        <h1> Bajas Activas </h1>
        <a href="/cuestionarioBaja" type="button" class="bt1"> Insertar Baja </a>
        <br><br>
            <table>
                <thead>
                    <tr>
                        <th> Estado </th>
                        <th> Fecha de Inicio</th>
                        <th> Duración </th>
                        <th> Motivo </th>
                        <th> Trabajador</th>
                        <th> Acciones </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datosBajasActivas as $dato)
                    <tr>
                        <!--
                        @if($dato->estado == 1)
                            <td style="background-color: rgba(142, 250, 148, 0.5);"> 
                                Activo
                            </td>
                        @else 
                            <td style="background-color: rgba(255, 146, 146, 0.57);">
                                Inactivo
                            </td>
                        @endif 
-->
                        @if($dato->estado == 1 && $dato->fecha_inicio <= $fechaActual)
                            <td style="background-color: rgba(142, 250, 148, 0.5);"> 
                                Activo
                            </td>
                        @elseif($dato->estado == 1 && $dato->fecha_inicio > $fechaActual)
                            <td style="background-color: rgba(255, 253, 146, 0.57);">
                                Pendiente
                            </td>
                        @else 
                            <td style="background-color: rgba(255, 146, 146, 0.57);">
                                Inactivo
                            </td>
                        @endif

                        <td> {{ Carbon\Carbon::parse($dato->fecha_inicio)->format('d-m-Y') }} </td>
                        <td> {{$dato->duracion}}</td>
                        <td>{{ $dato->motivo }}</td>
                        <td>{{$dato->bajas_fk1->nombre}}, {{$dato->bajas_fk1->apellido1}}  </td>
                        <!-- <td> <a href="/mostrarBaja" type="button"> Ver Detalles </a></td> -->
                        <td> 
                            <a href="/baja/{{ $dato->id_baja }}" type="button" class="bt1"> Ver Detalles </a>
                             @if($dato->estado == 1) 
                                <a href="#" type="button" class="bt1 btCancelar" data-baja-id="{{ $dato->id_baja }}"> Cancelar </a>
                            @else 
                            @endif 
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table id="table2">
            <br> <br>
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
                        @if($dato->estado == 1 && $dato->fecha_inicio <= $fechaActual)
                            <td style="background-color: rgba(142, 250, 148, 0.5);"> 
                                Activo
                            </td>
                        @elseif($dato->estado == 1 && $dato->fecha_inicio > $fechaActual)
                            <td style="background-color: rgba(255, 253, 146, 0.57);">
                                Pendiente
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
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const cancelButtons = document.querySelectorAll('.btCancelar');
        cancelButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); 
                const id_baja = this.getAttribute('data-baja-id');
                const confirmacion = confirm('¿Estás seguro de que deseas cancelar esta baja?');

                if (confirmacion) {
                    //alert('Baja cancelada correctamente.');
                    window.location.href = `/cancelarBaja/${id_baja}`;
                }

            });
        });
    });
</script>
@endsection <!-- end body -->