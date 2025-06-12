    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> email Cancelar </title>
    </head>
    <body>
        <h1> Se ha cancelado una baja </h1>
        <p> Se ha cancelado una  baja con trabajador con DNI: {{ $bajaCancelar['dni'] }} </p>
        <p> Nombre:  {{ $bajaCancelar['nombre'] }}</p>
        <p> Apellidos:  {{ $bajaCancelar['apellido1'] }},  {{ $bajaCancelar['apellido2'] }}</p>
        <p> con fecha de inicio {{ $bajaCancelar['fecha_inicio'] }} a fecha de fin {{ $bajaCancelar['fecha_fin'] }}</p>
        <p> con el motivo:  </p>
        <p>            {{ $bajaCancelar['motivo'] }}</p>

        
    </body>
    </html>