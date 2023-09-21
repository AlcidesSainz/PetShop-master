<?php
session_start();

$adminRole = 1; //El rol 1 corresponde al Admin
$isLoginSuccess = false;
$roleid = -1;

if (isset($_SESSION['loginSuccess'])) {
    $isLoginSuccess = $_SESSION['loginSuccess'];
}

if (isset($_SESSION['roleId'])) {
    $roleid = $_SESSION['roleId'];
}

$IsAdmin = $isLoginSuccess && $roleid == $adminRole;

if (!$IsAdmin) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['nombre'])) {
    $nombre = $_SESSION['nombre'];
    // Ahora $nombre contiene el valor de $_SESSION['nombre']
}

if (isset($_POST['cerrar_sesion'])) {
    // Destruir todas las variables de sesión
    session_unset();

    // Destruir la sesión
    session_destroy();

    // Redireccionar a una página después de cerrar la sesión (opcional)
    header("Location: index.php"); // Reemplaza "index.php" con la página a la que deseas redireccionar.
    exit();
}
function conectarBD()
{
    include("config.php");

    // Luego, puedes utilizar las variables de configuración en tu conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die('Error de conexión: ' . $conn->connect_error);
    }
    return $conn;


}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aumentar Proveedor</title>
    <!-- Agrega los estilos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="styles/styleRegistro.css" />
    <link rel="stylesheet" href="styles/styleIngresarProduct.css" />
</head>

<body>
    <!-- Menú lateral -->
    <div class="row  mt-5 m-auto ">
        <div class="col-2">
            <div class="sidebar">
                <h2>Menú de Admin</h2>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="ingresarProducto.php">Ingresar Nuevo Producto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="verProductos.php">Ver Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="anadirCant.php">Añadir Cantidad a Producto </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="anadirCategoria.php">Añadir Categoría</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="anadirTipoMascota.php">Añadir Tipo Mascota</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="anadirProveedor.php">Añadir Proveedor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="asignarAdmin.php">Gestión Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="historialCompras.php">Historial de ventas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Salir</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-10 mt-5 text-center">
            <div id="alert-container" class="mt-3"></div>
            <h2>Añade un proveedor </h2>
            <form id="proveedorForm">
                <label class="m-2" for="nombreProveedor">Ingrese el nombre del proveedor:</label><br>
                <input class="m-2" placeholder="Nombre" type="text" name="nombreProveedor" id="nombreProveedor">
                <br>
                <label class="m-2" for="direccionProveedor">Ingrese la dirección del proveedor:</label><br>
                <input class="m-2" placeholder="Dirección" type="text" name="direccionProveedor"
                    id="direccionProveedor">
                <br>
                <label class="m-2" for="telefonoProveedor">Ingrese el teléfono del proveedor:</label><br>
                <input class="m-2" placeholder="Teléfono" type="number" name="telefonoProveedor" id="telefonoProveedor">
                <br>
                <label class="m-2" for="email">Ingrese el correo del proveedor:</label><br>
                <input class="m-2" placeholder="Correo" type="email" name="correoProveedor" id="correoProveedor">
                <br>
                <button class="btn btn-success mt-3 anadirProveedor" id="anadirProveedor">Añadir Proveedor</button>
            </form>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <script>
                $(document).ready(function () {
                    $("#anadirProveedor").click(function (e) {
                        // Evita que el formulario se envíe de forma predeterminada
                        e.preventDefault();

                        // Serializa los datos del formulario en formato JSON
                        var formData = $("#proveedorForm").serialize();

                        // Realiza una solicitud POST al archivo PHP con los datos del formulario
                        $.ajax({
                            type: "POST",
                            url: "/php_functions/anadir_proveedor.php", // Reemplaza con la URL de tu archivo PHP
                            data: formData,
                            success: function (response) {
                                // Maneja la respuesta del servidor aquí
                                $("#alert-container").html(response);
                            },
                            error: function (error) {
                                // Maneja los errores aquí
                                console.log("Error: " + error);
                            }
                        });
                    });
                });
            </script>



</body>

</html>