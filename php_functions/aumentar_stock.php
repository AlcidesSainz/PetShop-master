<?php
if (isset($_POST['idProducto']) && isset($_POST['cantidad'])) {
    $idProducto = $_POST['idProducto'];
    $cantidadAumentar = $_POST['cantidad'];

    // Realiza una conexión a la base de datos (asegúrate de configurar los datos de conexión)
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

    // Consulta para aumentar el stock del producto
    $sql = "UPDATE producto SET stock = stock + ? WHERE idproducto = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $cantidadAumentar, $idProducto);

    if ($stmt->execute()) {
        echo "Stock aumentado exitosamente.";
    } else {
        echo "Error al aumentar el stock.";
    }

    $stmt->close();
    $con->close();
} else {
    echo "No se proporcionaron datos válidos.";
}
?>