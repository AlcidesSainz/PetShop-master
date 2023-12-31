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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="styles/styleRegistro.css" />
    <link rel="stylesheet" href="styles/styleIngresarProduct.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
</head>

<body>
    <div class="row">
        <!-- Menú lateral -->
        <div class="sidebar sidebarMenu ">
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
        <div class="container  tableProducts mt-5">
            <h2>Lista de Productos</h2>
            <table id="tablaProductos" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID Producto</th>
                        <th>Nombre del Producto</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Proveedor</th>
                        <th>Tipo de Mascota</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los datos se cargarán aquí automáticamente -->
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <!-- Configura y muestra la tabla en un script separado -->
    <script>
        $(document).ready(function () {
            // Configura la tabla DataTable
            $('#tablaProductos').DataTable({
                // Configuración personalizada aquí
                "ajax": {
                    "url": "/php_functions/obtener_productos.php", // URL para obtener los datos de la base de datos
                    "dataSrc": ""
                },
                "columns": [
                    { "data": "idproducto" },
                    { "data": "nombre_producto" },
                    { "data": "precio" },
                    { "data": "stock" },
                    { "data": "proveedor" },
                    { "data": "mascota" },
                    {
                        // Columna de acciones con botón de eliminar
                        "data": null,
                        "render": function (data, type, row) {
                            return '<button class="btn btn-danger eliminar-btn" data-id="' + row.idproducto + '">x</button>';
                        }
                    }
                ],
                "columnDefs": [
                    {
                        // Asigna un identificador a la columna de acciones
                        "targets": -1,
                        "className": "acciones"
                    }
                ]
            });
        });
        // Agrega un evento para manejar el clic en el botón de eliminar
        $('#tablaProductos').on('click', '.eliminar-btn', function () {
            debugger
            var idProducto = $(this).data('id'); // Obtiene el ID del producto del atributo data-id

            // Confirma con el usuario si realmente desea eliminar el producto
            if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {
                // Realiza la acción de eliminación enviando una solicitud AJAX al servidor
                // Realiza la acción de eliminación enviando una solicitud AJAX al servidor
                $.ajax({
                    url: '/php_functions/eliminar_producto.php', // Corregir la URL
                    type: 'POST',
                    data: { id: idProducto }, // Envía el ID del producto al servidor
                    success: function (response) {
                        // Maneja la respuesta del servidor, por ejemplo, recargar la tabla
                        if (response.success) {
                            // Actualiza la tabla o realiza alguna otra acción después de la eliminación
                            // Puedes recargar la tabla para que refleje los cambios
                            $('#tablaProductos').DataTable().ajax.reload();
                        } else {
                            alert('Error al eliminar el producto.');
                        }
                    },
                    error: function () {
                        alert('Error de comunicación con el servidor.');
                    }
                });

            }
        });

    </script>

</body>

</html>