<?php
function conectarBD()
{
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
    return $con; // Devolver la conexión
}



if (isset($_POST['idUsuario'])) {
    $idUsuario = $_POST['idUsuario'];
    $con = conectarBD();

    // Consulta para verificar si el usuario es administrador
    $sql = "DELETE FROM pet_shop.usuarios WHERE idusuarios = ?;";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $idUsuario);

    if ($stmt->execute()) {
        echo "El usuario con ID $idUsuario ha sido eliminado.";
    } else {
        echo "Error al eliminar el usuario.";
    }
    $stmt->close(); // Cierra la consulta preparada
    $con->close();

} else {
    echo "No se proporcionó un usuario válido.";
}
?>