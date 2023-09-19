<?php
// Conecta a la base de datos (asegúrate de configurar los datos de conexión)
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

// Obtener el ID del producto desde la solicitud GET
if (isset($_GET['idproducto'])) {
    $idProducto = $_GET['idproducto'];

    // Consulta para obtener el stock del producto por su ID
    $sql = "SELECT stock FROM producto WHERE idproducto = ?";
    $stmt = $con->prepare($sql);
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

$con->close();
?>