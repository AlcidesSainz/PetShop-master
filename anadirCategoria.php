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
    <title>Aumentar Categoria</title>
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
            <h2>Añade una nueva categoría de productos </h2>
            <label class="m-2" for="cantidad">Ingrese la categoría de producto que desea añadir: </label><br>
            <input class="m-2" placeholder="Nueva Categoria" type="text" name="categoriaProducto"
                id="categoriaProducto">
            <br>
            <button class="btn btn-success mt-3 anadirCategoria" id="anadirCategoria">Añadir Categoria</button>


            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <script>
                $(document).ready(function () {
                    $("#anadirCategoria").click(function () {
                        // Obtener el valor del campo de entrada
                        var nuevaCategoria = $("#categoriaProducto").val();

                        // Realizar una solicitud POST al archivo PHP para agregar la categoría
                        $.post("/php_functions/anadir_Categoria.php", { categoriaProducto: nuevaCategoria }, function (data) {
                            // Mostrar la respuesta del servidor
                            $("#alert-container").html(data);
                        });
                    });
                });
            </script>



</body>

</html>