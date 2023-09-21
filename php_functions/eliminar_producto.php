<?php
// Archivo: eliminar_producto.php

// Verificar si se ha recibido el ID del producto a eliminar
if (isset($_POST['id'])) {
    // Obtener el ID del producto desde la solicitud
    $idProducto = $_POST['id'];

    include("../config.php");


    // Luego, puedes utilizar las variables de configuración en tu conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die('Error de conexión: ' . $conn->connect_error);
    }


    // Consulta SQL para eliminar el producto por ID
    $sql = "DELETE FROM producto WHERE idproducto = ?";

    // Preparar la consulta
    $stmt = $conn->prepare($sql);

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
    $conn->close();

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