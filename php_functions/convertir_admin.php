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
    $sql = "SELECT roleId FROM usuarios WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $stmt->bind_result($esAdmin);
    $stmt->fetch();
    $stmt->close(); // Cierra la consulta preparada

    if ($esAdmin == 2 || is_null($esAdmin)) {
        // Actualiza el campo esAdmin a 1 (administrador)
        $updateSql = "UPDATE usuarios SET roleId = 1 WHERE id = ?";
        $updateStmt = $con->prepare($updateSql);
        $updateStmt->bind_param("i", $idUsuario);
        $updateStmt->execute();
        $updateStmt->close(); // Cierra la segunda consulta preparada

        echo "El usuario con ID $idUsuario se ha convertido en administrador.";
    } else {
        echo "El usuario con ID $idUsuario ya es administrador.";
    }

    $con->close();
} else {
    echo "No se proporcionó un usuario válido.";
}
?>