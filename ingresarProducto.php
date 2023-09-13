    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Menu Ingreso Producto</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- Agrega los estilos CSS de Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
        <link rel="stylesheet" href="styles/styleRegistro.css" />
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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Captura los datos del formulario
            $producto = $_POST["producto"];
            $precio = $_POST["precio"];
            $cantidad = $_POST["cantidad"];
            $categoria = $_POST["categoria"];
            $proveedor = $_POST["proveedor"];
            $mascota = $_POST["mascota"];

            $imagenNombre = $_FILES['imagen']['name'];
            $imagenTmp = $_FILES['imagen']['tmp_name'];
            $imagenTipo = $_FILES['imagen']['type'];

            $directorioImagenes = 'img/products';

            if (!empty($imagenNombre)) {
                $imagenNombre = uniqid() . '_' . $imagenNombre;

                move_uploaded_file($imagenTmp, $directorioImagenes . $imagenNombre);
            } else {
                $imagenNombre = 'imagen_por_defecto';
            }

            // Llama a la función para insertar el producto
            $mensaje = insertarProducto($producto, $precio, $cantidad, $categoria, $proveedor, $mascota, $imagenNombre);

            echo $mensaje;
        }
        ?>


        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Producto" required name="producto" id="producto" />
            </div>
            <div class="form-group">
                <input type="number" class="form-control" placeholder="Precio" required name="precio" id="precio" />
            </div>
            <div class="form-group">
                <input type="number" class="form-control" placeholder="Cantidad" required name="cantidad" id="cantidad" />
            </div>
            <select class="form-control" name="categoria" id="categoria">
                <option value="" disabled selected>Categoria</option>
                <?php
                $categorias = obtenerCategorias();
                foreach ($categorias as $categoria) {
                    echo '<option value="' . $categoria . '">' . $categoria . '</option>';
                }
                ?>
            </select>
            <select class="form-control" name="proveedor" id="proveedor">
                <option value="" disabled selected>Proveedor</option>
                <?php
                $nombresProveedores = obtenerNombresProveedores();
                foreach ($nombresProveedores as $nombreProveedor) {
                    echo '<option value="' . $nombreProveedor . '">' . $nombreProveedor . '</option>';
                }
                ?>
            </select>
            <select class="form-control" name="mascota" id="mascota">
                <option value="" disabled selected>Mascota</option>
                <?php
                $tipoMascotas = obtenerTipoMascota();
                foreach ($tipoMascotas as $tipoMascota) {
                    echo '<option value="' . $tipoMascota . '">' . $tipoMascota . '</option>';
                }
                ?>
            </select>
            <div class="form-group">
                <label for="imagen">Selecciona una imagen:</label>
                <input type="file" name="imagen" id="imagen" accept="image/*">
            </div>
            <!-- Agrega más campos de registro si es necesario -->
            <button type="submit" class="btn btn-registro btn-block">
                Añadir Producto
            </button>

        </form>
        <!-- Agrega los scripts de Bootstrap y jQuery (si es necesario) -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>

    </html>