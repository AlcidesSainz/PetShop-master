<?php
function conectarBD()
{
    include("../config.php");


    // Luego, puedes utilizar las variables de configuración en tu conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die('Error de conexión: ' . $conn->connect_error);
    }
    return $conn;
}



if (isset($_POST['idUsuario'])) {
    $idUsuario = $_POST['idUsuario'];
    $con = conectarBD();

    // Consulta para verificar si el usuario es administrador
    $sql = "DELETE FROM pet_shop.usuarios WHERE id = ?;";
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