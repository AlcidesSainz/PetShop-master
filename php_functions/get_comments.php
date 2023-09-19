<?php
$host = "localhost";
$port = 3306;
$socket = "";
$user = "root";
$password = "root";
$dbname = "pet_shop";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die('Could not connect to the database server' . mysqli_connect_error());

$query = "SELECT nombre, comentario FROM comentarios";
$result = $con->query($query);

$comments = array();

while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}

$con->close();

header('Content-Type: application/json');
echo json_encode($comments);
?>