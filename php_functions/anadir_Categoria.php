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
    // Verificar si se ha enviado una nueva categoría
    if (isset($_POST["categoriaProducto"])) {
        $categoriaProducto = $_POST["categoriaProducto"];

        // Conectar a la base de datos
        $con = conectarBD();

        // Evitar problemas de inyección de SQL utilizando sentencias preparadas
        $stmt = $con->prepare("INSERT INTO categorias_productos (categoria) VALUES (?)");
        $stmt->bind_param("s", $categoriaProducto);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Categoría añadida con éxito.";
        } else {
            echo "Error al añadir la categoría: " . $stmt->error;
        }

        // Cerrar la conexión
        $stmt->close();
        $con->close();
    } else {
        echo "No se ha proporcionado una nueva categoría.";
    }
}
?>