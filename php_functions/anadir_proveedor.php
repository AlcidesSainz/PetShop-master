<?php
// Verificar si la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recuperar los datos del formulario
    $nombreProveedor = $_POST["nombreProveedor"];
    $direccionProveedor = $_POST["direccionProveedor"];
    $telefonoProveedor = $_POST["telefonoProveedor"];
    $correoProveedor = $_POST["correoProveedor"];

    // Validar los datos si es necesario (por ejemplo, verificar que no estén vacíos)

    // Realizar la conexión a la base de datos (ajusta las credenciales según tu configuración)
    include("../config.php");


    // Luego, puedes utilizar las variables de configuración en tu conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die('Error de conexión: ' . $conn->connect_error);
    }
    

    // Preparar la consulta SQL para insertar un nuevo proveedor
    $sql = "INSERT INTO proveedor (nombreProveedor, direccion, telefono, correo) VALUES (?, ?, ?, ?)";

    // Preparar una sentencia SQL
    $stmt = $conn->prepare($sql);

    // Vincular los parámetros con los valores
    $stmt->bind_param("ssss", $nombreProveedor, $direccionProveedor, $telefonoProveedor, $correoProveedor);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Proveedor añadido con éxito.";
    } else {
        echo "Error al añadir el proveedor: " . $stmt->error;
    }

    // Cerrar la sentencia y la conexión
    $stmt->close();
    $conn->close();
} else {
    echo "No se ha enviado una solicitud POST.";
}
?>