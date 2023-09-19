<?php
$host = "localhost";
$port = 3306;
$socket = "";
$user = "root";
$password = "root";
$dbname = "pet_shop";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die('Could not connect to the database server' . mysqli_connect_error());

//$con->close();




// Verifica la conexión
if ($con->connect_error) {
    die("Error en la conexión: " . $con->connect_error);
}

// Consulta SQL para obtener los datos de productos
$sql = "SELECT p.idproducto, p.nombre_producto, p.precio, p.stock, pr.nombreProveedor AS proveedor, tm.mascota AS mascota 
        FROM producto p 
        INNER JOIN proveedor pr ON p.proveedor = pr.idproveedor 
        INNER JOIN tipomascota tm ON p.tipomascota = tm.idtipoMascota";

$result = $con->query($sql);

// Prepara un arreglo para almacenar los resultados
$productos = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

// Cierra la conexión a la base de datos
$con->close();

// Devuelve los resultados como JSON
echo json_encode($productos);
?>