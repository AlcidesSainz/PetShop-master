<?php
function conectarBD()
{
    include("../config.php");


    // Luego, puedes utilizar las variables de configuración en tu conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die('Error de conexión: ' . $conn->connect_error);
    }
    return $conn;
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