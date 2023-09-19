<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Ingreso Producto</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Agrega los estilos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="styles/styleRegistro.css" />
    <link rel="stylesheet" href="styles/styleIngresarProduct.css" />
</head>

<body>
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
    function obtenerCategorias()
    {
        $con = conectarBD();

        $sql = "SELECT categoria FROM categorias_productos";
        $result = $con->query($sql);

        $categorias = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $categorias[] = $row['categoria'];
            }
        }

        $con->close();

        return $categorias;
    }
    function obtenerNombresProveedores()
    {
        $con = conectarBD();

        $sql = "SELECT nombreProveedor FROM proveedor";
        $result = $con->query($sql);

        $nombresProveedores = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $nombresProveedores[] = $row['nombreProveedor'];
            }
        }

        $con->close();

        return $nombresProveedores;
    }
    function obtenerTipoMascota()
    {
        $con = conectarBD();
        $sql = "SELECT mascota from tipomascota";
        $result = $con->query($sql);

        $tipoMascotas = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tipoMascotas[] = $row['mascota'];
            }
        }
        $con->close();
        return $tipoMascotas;
    }

    function insertarProducto($producto, $precio, $cantidad, $categoria, $proveedor, $mascota, $imagenNombre)
    {
        $con = conectarBD();

        // Prepara la sentencia SQL
        $sql = "INSERT INTO producto (nombre_producto, precio, stock, categoria, proveedor, tipomascota, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);

        if ($stmt) {
            // Asocia los parámetros y ejecuta la consulta
            $stmt->bind_param("sssssss", $producto, $precio, $cantidad, $categoria, $proveedor, $mascota, $imagenNombre);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                return "Producto insertado exitosamente.";
            } else {
                return "Error al insertar el producto.";
            }

            $stmt->close();
        } else {
            return "Error en la preparación de la consulta.";
        }

        $con->close();
    }
    function obtenerIdCategoria($nombreCategoria)
    {
        $con = conectarBD();
        $sql = "SELECT idcategorias_productos FROM categorias_productos WHERE categoria = ?";
        $stmt = $con->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $nombreCategoria);
            $stmt->execute();
            $stmt->bind_result($id);
            $stmt->fetch();
            $stmt->close();
            $con->close();
            return $id;
        } else {
            return null; // Maneja el error adecuadamente en tu aplicación
        }
    }
    function obtenerIdProveedor($nombreProveedor)
    {
        $con = conectarBD();
        $sql = "SELECT idproveedor  FROM proveedor WHERE nombreProveedor = ?";
        $stmt = $con->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $nombreProveedor);
            $stmt->execute();
            $stmt->bind_result($id);
            $stmt->fetch();
            $stmt->close();
            $con->close();
            return $id;
        } else {
            return null; // Maneja el error adecuadamente en tu aplicación
        }
    }
    function obtenerIdMascota($tipoMascota)
    {
        $con = conectarBD();
        $sql = "SELECT idtipoMascota  FROM tipomascota WHERE mascota = ?";
        $stmt = $con->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $tipoMascota);
            $stmt->execute();
            $stmt->bind_result($id);
            $stmt->fetch();
            $stmt->close();
            $con->close();
            return $id;
        } else {
            return null; // Maneja el error adecuadamente en tu aplicación
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Captura los datos del formulario
        $producto = $_POST["producto"];
        $precio = $_POST["precio"];
        $cantidad = $_POST["cantidad"];
        $categoria = $_POST["categoria"];
        $nombreProveedor = $_POST["proveedor"];
        $tipoMascota = $_POST["mascota"];

        $imagenNombre = $_FILES['imagen']['name'];
        $imagenTmp = $_FILES['imagen']['tmp_name'];
        $imagenTipo = $_FILES['imagen']['type'];

        $directorioImagenes = 'img/products/';

        if (!empty($imagenNombre)) {
            $imagenNombre = uniqid() . '_' . $imagenNombre;

            move_uploaded_file($imagenTmp, $directorioImagenes . $imagenNombre);
        } else {
            $imagenNombre = 'imagen_por_defecto';
        }

        // Llama a la función para insertar el producto
        $mensaje = insertarProducto($producto, $precio, $cantidad, $categoria, $nombreProveedor, $tipoMascota, $imagenNombre);

        header("Location: ingresarProducto.php"); // Cambia "confirmacion.php" al nombre de tu página de confirmación
        exit;
    }
    ?>
    <!-- Menú lateral -->
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
                <a class="nav-link" href="asignarAdmin.php">Asignar Nuevo Admin</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php">Salir</a>
            </li>
        </ul>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto mt-5">
                <!-- Contenido del div centrado -->
                <div class="ingresar-container">
                    <h3 class="text-center">Ingresa un nuevo producto</h3>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Producto" required name="producto"
                                id="producto" />
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Precio" required name="precio"
                                id="precio" step="0.01" />
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" placeholder="Cantidad" required name="cantidad"
                                id="cantidad" />
                        </div>
                        <select class="form-control" name="categoria" id="categoria">
                            <option value="" disabled selected>Categoria</option>
                            <?php
                            $categorias = obtenerCategorias();
                            foreach ($categorias as $categoria) {
                                $categoriaId = obtenerIdCategoria($categoria);
                                echo '<option value="' . $categoriaId . '">' . $categoria . '</option>';
                            }
                            ?>
                        </select>
                        <br>
                        <select class="form-control" name="proveedor" id="proveedor">
                            <option value="" disabled selected>Proveedor</option>
                            <?php
                            $nombresProveedores = obtenerNombresProveedores();
                            foreach ($nombresProveedores as $nombreProveedor) {
                                $proveedorId = obtenerIdProveedor($nombreProveedor);
                                echo '<option value="' . $proveedorId . '">' . $nombreProveedor . '</option>';
                            }
                            ?>
                        </select>
                        <br>
                        <select class="form-control" name="mascota" id="mascota">
                            <option value="" disabled selected>Mascota</option>
                            <?php
                            $tipoMascotas = obtenerTipoMascota();
                            foreach ($tipoMascotas as $tipoMascota) {
                                $mascotaId = obtenerIdMascota($tipoMascota);
                                echo '<option value="' . $mascotaId . '">' . $tipoMascota . '</option>';
                            }
                            ?>
                        </select>
                        <br>
                        <div class="form-group">
                            <label for="imagen">Selecciona una imagen:</label>
                            <input type="file" name="imagen" id="imagen" accept="image/*">
                        </div>
                        <!-- Agrega más campos de registro si es necesario -->
                        <button type="submit" class="btn btn-registro btn-block">
                            Añadir Producto
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Agrega los scripts de Bootstrap y jQuery (si es necesario) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>