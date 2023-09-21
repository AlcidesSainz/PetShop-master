<?php
include("../config.php");


// Luego, puedes utilizar las variables de configuración en tu conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}


// Obtener el ID del producto desde la solicitud GET
if (isset($_GET['idproducto'])) {
    $idProducto = $_GET['idproducto'];

    // Consulta para obtener el stock del producto por su ID
    $sql = "SELECT stock FROM producto WHERE idproducto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idProducto);
    $stmt->execute();
    $stmt->bind_result($stock);
    $stmt->fetch();
    $stmt->close();

    // Devolver la cantidad de stock como respuesta
    echo $stock;
} else {
    echo "No se proporcionó un ID de producto válido.";
}

$conn->close();
?>