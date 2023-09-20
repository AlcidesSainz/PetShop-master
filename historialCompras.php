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
                    <a class="nav-link" href="historialCompras.php">Historial de compras</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Salir</a>
                </li>
            </ul>
        </div>
        <div class="container  tableProducts mt-5">
            <h2>Historial de ventas</h2>
            <table id="tablaProductos" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID Venta</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Fecha Venta</th>
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
                    "url": "/php_functions/obtener_ventas.php", // URL para obtener los datos de la base de datos
                    "dataSrc": ""
                },
                "columns": [
                    { "data": "id" },
                    { "data": "producto" },
                    { "data": "cantidad" },
                    { "data": "valor" },
                    { "data": "fecha" }
                ]
            });
        });


    </script>

</body>

</html>