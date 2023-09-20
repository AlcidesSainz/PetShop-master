<?php

function conectarBD()
{
    $host = "localhost";
    $port = 3306;
    $socket = "";
    $user = "root";
    $password = "root";
    $dbname = "pet_shop";

    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
        or die('Could not connect to the database server' . mysqli_connect_error());

    //$con->close();
    return $con;


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