<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> email</title>
</head>
<body>
    <h1> Nueva baja </h1>
    <p> Se ha registrado una nueva baja al trabajador con DNI: {{ $bajaNueva['dni'] }} </p>
    <p> con fecha de inicio {{ $bajaNueva['fecha_inicio'] }} a fecha de fin {{ $bajaNueva['fecha_fin'] }}</p>
    <p> con el motivo:  </p>
    <p>            {{ $bajaNueva['motivo'] }}</p>

    
</body>
</html>