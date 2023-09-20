<?php
function conectarBD()
{
    $host = "localhost";
    $port = 3306;
    $socket = "";
    $user = "root";
    $password = "root";
    $dbname = "pet_shop";

    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
        or die('Could not connect to the database server' . mysqli_connect_error());

    return $con;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha enviado un nuevo tipo de mascota
    if (isset($_POST["tipoMascota"])) {
        $tipoMascota = $_POST["tipoMascota"];

        // Conectar a la base de datos
        $con = conectarBD();

        // Evitar problemas de inyección de SQL utilizando sentencias preparadas
        $stmt = $con->prepare("INSERT INTO tipomascota (mascota) VALUES (?)");
        $stmt->bind_param("s", $tipoMascota);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">
                Tipo de mascota añadido con éxito.
            </div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">
                Error al añadir el tipo de mascota: ' . $stmt->error . '
            </div>';
        }

        // Cerrar la conexión
        $stmt->close();
        $con->close();
    } else {
        echo '<div class="alert alert-danger" role="alert">
            No se ha proporcionado un nuevo tipo de mascota.
        </div>';
    }
}
?>