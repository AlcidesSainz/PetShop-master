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
    $sql = "SELECT esAdmin FROM usuarios WHERE idusuarios = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $stmt->bind_result($esAdmin);
    $stmt->fetch();
    $stmt->close(); // Cierra la consulta preparada

    if ($esAdmin == 1) {
        // Actualiza (administrador) a 0
        $updateSql = "UPDATE usuarios SET esAdmin = 0 WHERE idusuarios = ?";
        $updateStmt = $con->prepare($updateSql);
        $updateStmt->bind_param("i", $idUsuario);
        $updateStmt->execute();
        $updateStmt->close(); // Cierra la segunda consulta preparada

        echo "El usuario con ID $idUsuario ha dejado de ser administrador.";
    } else {
        echo "El usuario con ID $idUsuario ya no administrador.";
    }

    $con->close();
} else {
    echo "No se proporcionó un usuario válido.";
}
?>