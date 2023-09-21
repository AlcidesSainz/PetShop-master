<?php
include("../config.php");


// Luego, puedes utilizar las variables de configuración en tu conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}




// Verifica la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener los datos de productos
$sql = "SELECT p.idproducto, p.nombre_producto, p.precio, p.stock, pr.nombreProveedor AS proveedor, tm.mascota AS mascota 
        FROM producto p 
        INNER JOIN proveedor pr ON p.proveedor = pr.idproveedor 
        INNER JOIN tipomascota tm ON p.tipomascota = tm.idtipoMascota";

$result = $conn->query($sql);

// Prepara un arreglo para almacenar los resultados
$productos = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

// Cierra la conexión a la base de datos
$conn->close();

// Devuelve los resultados como JSON
echo json_encode($productos);
?>