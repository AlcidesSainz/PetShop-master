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
function obtenerProductos()
{
    $con = conectarBD();
    $sql = "SELECT nombre_producto FROM producto";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $nombreUsuario = $row['nombre_producto'];
            echo '<option value="' . $nombreUsuario . '">' . $nombreUsuario . '</option>';
        }
    }

    $con->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aumentar Stock</title>
    <!-- Agrega los estilos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="styles/styleRegistro.css" />
    <link rel="stylesheet" href="styles/styleIngresarProduct.css" />
</head>

<body>
    <!-- Menú lateral -->
    <div class="container-fluid">
        <div class="row  mt-5 m-auto ">
            <div class="col-lg-2 col-md-3 col-sm-4">
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
            <div class="col-lg-10 col-md-9 col-sm-8 mt-5 text-center">
                <div id="alert-container" class="mt-3"></div>

                <div id="alert-container" class="mt-3"></div>
                <h2>Producto para aumentar el stock: </h2>
                <select class="form-control mt-3 mx-auto" name="producto" id="producto" style="width: 200px;">
                    <option value="" disabled selected>Productos</option>
                    <?php

                    $con = conectarBD();
                    $sql = "SELECT idproducto,nombre_producto FROM producto";
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $idproducto = $row['idproducto'];
                            $nombre_producto = $row['nombre_producto'];
                            echo '<option value="' . $idproducto . '">' . $nombre_producto . '</option>';
                        }
                    }

                    $con->close();

                    ?>
                </select><br>
                <span id="stockDisponible" class="mt-2">Stock Disponible: </span><br>

                <label class="m-2" for="cantidad">Ingrese la cantidad de stock que desea aumentar del producto:
                </label><br>
                <input class="m-2" placeholder="Cantidad a aumentar" type="number" name="cantidad" id="cantidad" min="0"
                    oninput="validarCantidad(this)">
                <!-- Validar que los valores no sean mayores a 100 y menores a 0 -->
                <script>
                    function validarCantidad(input) {
                        if (input.value < 0) {
                            input.value = 0;
                        } else if (input.value > 100) {
                            input.value = 100;
                        }
                    }
                </script><br>

                <button class="btn btn-success mt-3 aumentarStock" id="aumentarStockBtn">Aumentar Stock</button>


                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                <script>
                    $(document).ready(function () {

                        // Función para cargar y mostrar el stock disponible
                        function cargarStockDisponible() {
                            var productoSeleccionado = $("#producto").val();

                            // Realizar una solicitud AJAX utilizando jQuery
                            $.ajax({
                                url: "/php_functions/obtenerStockProducto.php",
                                method: "GET",
                                data: { idproducto: productoSeleccionado },
                                success: function (data) {
                                    // Cuando se reciba la respuesta AJAX, actualiza el valor del span
                                    $("#stockDisponible").text("Stock Disponible: " + data);

                                }
                            });
                        }

                        // Llama a la función cuando se cambie la selección del producto
                        $("#producto").on("change", cargarStockDisponible);


                        // Llamado Ajax para aumentar stock
                        $("#aumentarStockBtn").on("click", function () {
                            var productoSeleccionado = $("#producto").val();
                            var cantidadAumentar = parseInt($("#cantidad").val()) || 0;

                            if (productoSeleccionado && cantidadAumentar > 0) {
                                $.ajax({
                                    url: "/php_functions/aumentar_stock.php",
                                    method: "POST",
                                    data: {
                                        idProducto: productoSeleccionado,
                                        cantidad: cantidadAumentar
                                    },
                                    success: function (response) {
                                        // Mostrar una alerta de Bootstrap con la respuesta del servidor
                                        $("#alert-container").html(
                                            '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                            response +
                                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                            '<span aria-hidden="true">&times;</span>' +
                                            '</button>' +
                                            '</div>'
                                        );
                                    },
                                    error: function () {
                                        // Mostrar una alerta de Bootstrap con un mensaje de error
                                        $("#alert-container").html(
                                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                            'Error al realizar la solicitud.' +
                                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                            '<span aria-hidden="true">&times;</span>' +
                                            '</button>' +
                                            '</div>'
                                        );
                                    }
                                });
                            } else {
                                // Mostrar una alerta de Bootstrap con un mensaje de advertencia
                                $("#alert-container").html(
                                    '<div class="alert alert-warning alert-dismissible fade show" role="alert">' +
                                    'Selecciona un producto y proporciona una cantidad válida.' +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                    '<span aria-hidden="true">&times;</span>' +
                                    '</button>' +
                                    '</div>'
                                );
                            }
                        });
                    });
                </script>

            </div>

</body>

</html>