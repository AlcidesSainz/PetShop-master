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
function obtenerUsuarios()
{
    $con = conectarBD();
    $sql = "SELECT nombre FROM usuarios";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $nombreUsuario = $row['nombre'];
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
    <title>Gestión Usuarios</title>
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
            <!-- Dar Permiso de Administrador -->
            <div id="alert-container" class="mt-3"></div>
            <h2>Elije el usuario que quieres CONVERTIR en administrador: </h2>
            <select class="form-control mt-3 mx-auto" name="usuario" id="usuario" style="width: 200px;">
                <option value="" disabled selected>Usuarios</option>
                <?php

                $con = conectarBD();
                $sql = "SELECT id,nombre FROM usuarios WHERE roleId !=1";
                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $idUsuario = $row['id'];
                        $nombreUsuario = $row['nombre'];
                        echo '<option value="' . $idUsuario . '">' . $nombreUsuario . '</option>';
                    }
                }

                $con->close();

                ?>
            </select>
            <button class="btn btn-success mt-3 convertirAdmin">Convertir en Administrador</button>

            <!-- Quitar permiso de admin -->

            <div id="alert-container2" class="mt-3"></div>
            <h2>Elije el usuario que quieres QUITAR de administrador: </h2>
            <select class="form-control mt-3 mx-auto" name="usuarioAdmin" id="usuarioAdmin" style="width: 200px;">
                <option value="" disabled selected>Usuarios Aministradores</option>
                <?php

                $con = conectarBD();
                $sql = "SELECT id,nombre FROM usuarios WHERE roleId = 1";
                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $idUsuario = $row['id'];
                        $nombreUsuario = $row['nombre'];
                        echo '<option value="' . $idUsuario . '">' . $nombreUsuario . '</option>';
                    }
                }

                $con->close();

                ?>
            </select>
            <button class="btn btn-success mt-3 quitarAdmin">Eliminar de Administrador</button>

            <!-- Eliminar usuario -->

            <div id="alert-container3" class="mt-3"></div>
            <h2>Elije el usuario que quieres Eliminar de la Base de Datos: </h2>
            <select class="form-control mt-3 mx-auto" name="eliminarUser" id="eliminarUser" style="width: 200px;">
                <option value="" disabled selected>Usuarios</option>
                <?php

                $con = conectarBD();
                $sql = "SELECT id,nombre FROM usuarios WHERE roleId = 2 or roleId IS NULL";
                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $idUsuario = $row['id'];
                        $nombreUsuario = $row['nombre'];
                        echo '<option value="' . $idUsuario . '">' . $nombreUsuario . '</option>';
                    }
                }

                $con->close();

                ?>
            </select>
            <button class="btn btn-success mt-3 eliminarUsuario">Eliminar Usuario</button>
        </div>


    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {

            $('.convertirAdmin').on('click', function () {
                debugger
                const selectedUserId = $('#usuario').val();
                if (selectedUserId) {
                    // Enviar una solicitud AJAX con el ID del usuario
                    $.ajax({
                        url: '/php_functions/convertir_admin.php',
                        type: 'POST',
                        data: { idUsuario: selectedUserId }, // Cambiado a idUsuario
                        success: function (response) {
                            // Mostrar una alerta de Bootstrap con el mensaje de respuesta
                            $('#alert-container').html(
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
                            $('#alert-container').html(
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
                    // Mostrar una alerta de Bootstrap si no se selecciona un usuario
                    $('#alert-container').html(
                        '<div class="alert alert-warning alert-dismissible fade show" role="alert">' +
                        'Selecciona un usuario primero.' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '</div>'
                    );
                }
            });

            $('.quitarAdmin').on('click', function () {
                debugger
                const selectedUserId = $('#usuarioAdmin').val();
                if (selectedUserId) {
                    // Enviar una solicitud AJAX con el ID del usuario
                    $.ajax({
                        url: '/php_functions/quitar_admin.php',
                        type: 'POST',
                        data: { idUsuario: selectedUserId }, // Cambiado a idUsuario
                        success: function (response) {
                            // Mostrar una alerta de Bootstrap con el mensaje de respuesta
                            $('#alert-container2').html(
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
                            $('#alert-container2').html(
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
                    // Mostrar una alerta de Bootstrap si no se selecciona un usuario
                    $('#alert-container2').html(
                        '<div class="alert alert-warning alert-dismissible fade show" role="alert">' +
                        'Selecciona un usuario primero.' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '</div>'
                    );
                }
            });
            $('.eliminarUsuario').on('click', function () {
                debugger
                const selectedUserId = $('#eliminarUser').val();
                if (selectedUserId) {
                    // Enviar una solicitud AJAX con el ID del usuario
                    $.ajax({
                        url: '/php_functions/eliminar_user.php',
                        type: 'POST',
                        data: { idUsuario: selectedUserId }, // Cambiado a idUsuario
                        success: function (response) {
                            // Mostrar una alerta de Bootstrap con el mensaje de respuesta
                            $('#alert-container3').html(
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
                            $('#alert-container3').html(
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
                    // Mostrar una alerta de Bootstrap si no se selecciona un usuario
                    $('#alert-container3').html(
                        '<div class="alert alert-warning alert-dismissible fade show" role="alert">' +
                        'Selecciona un usuario primero.' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '</div>'
                    );
                }
            });
        });
    </script>



</body>

</html>