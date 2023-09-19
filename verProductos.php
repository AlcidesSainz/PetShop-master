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
                    <a class="nav-link" href="asignarAdmin.php">Asignar Nuevo Admin</a>
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
                    { "data": "tipomascota" }
                ]
            });
        });

    </script>
</body>

</html>