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
    <title>Aumentar Tipo Mascota</title>
    <!-- Agrega los estilos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="styles/styleRegistro.css" />
    <link rel="stylesheet" href="styles/styleIngresarProduct.css" />
</head>

<body>
    <!-- Menú lateral -->
    <div class="row mt-5 m-auto">
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
                        <a class="nav-link" href="anadirCant.php">Añadir Cantidad a Producto</a>
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
            <h2>Añade un nuevo tipo de mascota:</h2>
            <label class="m-2" for="cantidad">Ingrese el nuevo tipo de mascota:</label><br>
            <input class="m-2" placeholder="Nueva Mascota" type="text" name="tipoMascota" id="tipoMascota">
            <br>
            <button class="btn btn-success mt-3 anadirMascota" id="anadirMascota">Añadir Mascota</button>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <script>
                $(document).ready(function () {
                    $("#anadirMascota").click(function () {
                        // Obtener el valor del campo de entrada
                        var nuevaMascota = $("#tipoMascota").val();

                        // Realizar una solicitud POST al archivo PHP para agregar el tipo de mascota
                        $.post("/php_functions/anadir_tipoMascota.php", { tipoMascota: nuevaMascota }, function (data) {
                            // Mostrar la respuesta del servidor
                            $("#alert-container").html(data);
                        });
                    });
                });
            </script>
        </div>
    </div>
</body>

</html>