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