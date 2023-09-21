<?php
if (isset($_POST['idProducto']) && isset($_POST['cantidad'])) {
    $idProducto = $_POST['idProducto'];
    $cantidadAumentar = $_POST['cantidad'];

    include("../config.php");


    // Luego, puedes utilizar las variables de configuración en tu conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die('Error de conexión: ' . $conn->connect_error);
    }


    // Consulta para aumentar el stock del producto
    $sql = "UPDATE producto SET stock = stock + ? WHERE idproducto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $cantidadAumentar, $idProducto);

    if ($stmt->execute()) {
        echo "Stock aumentado exitosamente.";
    } else {
        echo "Error al aumentar el stock.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No se proporcionaron datos válidos.";
}
?>