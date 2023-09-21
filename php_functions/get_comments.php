<?php
include("../config.php");


// Luego, puedes utilizar las variables de configuración en tu conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}
$query = "SELECT nombre, comentario FROM comentarios";
$result = $conn->query($query);

$comments = array();

while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($comments);
?>