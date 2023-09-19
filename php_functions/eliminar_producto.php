<?php
// Archivo: eliminar_producto.php

// Verificar si se ha recibido el ID del producto a eliminar
if (isset($_POST['id'])) {
    // Obtener el ID del producto desde la solicitud
    $idProducto = $_POST['id'];

    // Conectar a la base de datos (asegúrate de configurar los datos de conexión)
    $host = "localhost";
    $port = 3306;
    $socket = "";
    $user = "root";
    $password = "root";
    $dbname = "pet_shop";

    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
        or die('Could not connect to the database server' . mysqli_connect_error());

    // Verificar la conexión
    if ($con->connect_error) {
        die("Error en la conexión: " . $con->connect_error);
    }

    // Consulta SQL para eliminar el producto por ID
    $sql = "DELETE FROM producto WHERE idproducto = ?";

    // Preparar la consulta
    $stmt = $con->prepare($sql);

    if ($stmt) {
        // Vincular el ID del producto a la consulta
        $stmt->bind_param("i", $idProducto);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // La eliminación se realizó con éxito
            $response = array('success' => true);
        } else {
            // Error al ejecutar la consulta de eliminación
            $response = array('success' => false, 'error' => 'Error al eliminar el producto.');
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        // Error al preparar la consulta
        $response = array('success' => false, 'error' => 'Error al preparar la consulta.');
    }

    // Cerrar la conexión a la base de datos
    $con->close();

    // Devolver la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // No se recibió el ID del producto
    $response = array('success' => false, 'error' => 'ID del producto no proporcionado.');
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>