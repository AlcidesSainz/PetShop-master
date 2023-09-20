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
                $sql = "SELECT idusuarios,nombre FROM usuarios";
                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $idUsuario = $row['idusuarios'];
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
                $sql = "SELECT idusuarios,nombre FROM usuarios WHERE esAdmin = 1";
                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $idUsuario = $row['idusuarios'];
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
                $sql = "SELECT idusuarios,nombre FROM usuarios WHERE esAdmin = 0 or esAdmin IS NULL";
                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $idUsuario = $row['idusuarios'];
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