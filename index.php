<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Prueba </title>
</head>
<body>
    <h1> hola </h1>
    <?php
        $host = "localhost";
        $port = "5432"; 
        $dbname = "prueba";
        $user = "postgre";
        $password = "postgres";

        try {
            // Conexión usando PDO (recomendado)
            $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            echo "<p>Conexión exitosa a PostgreSQL.</p>";
            
        } catch (PDOException $e) {
            echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
        } finally {
            // Cerrar conexión
            $conn = null;
        }
    ?> <!-- end php -->
</body>
</html>