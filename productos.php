<?php
session_start();
// $_SESSION['loginSuccess'] = $loginSuccess; // Puedes guardar otros datos en la sesión según tus necesidades
// $_SESSION['id'] = $id;
// $_SESSION['nombre'] = $nombre;
// $_SESSION['email'] = $email;
// $_SESSION['roleId'] = $roleId;

$isLoginSuccess = false;
$nombre = "";

if (isset($_SESSION['loginSuccess'])) {
    $isLoginSuccess = $_SESSION['loginSuccess'];
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Requerir el archivo que contiene la definición de la función actualizarStock2
    require_once 'productos.php'; // Reemplaza con la ruta correcta

    // Comprobar si se han recibido los parámetros necesarios
    if (isset($_POST['productoId']) && isset($_POST['cantidad'])) {
        // Obtener los valores de los parámetros
        $productoId = $_POST['productoId'];
        $cantidad = $_POST['cantidad'];

        // Llamar a la función actualizarStock2
        actualizarStock2($productoId, $cantidad);
    }
}
?>

<?php
// Verifica si se envió una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si se envió el ID del producto
    if (isset($_POST["productIdList"])) {
        // Obtiene el ID del producto desde la solicitud AJAX
        $productIdList = $_POST["productIdList"];

        // Llama a la función obtenerListProducto y obtiene los datos del producto
        $datosProductos = obtenerListProducto($productIdList);

        // Devuelve los datos del producto como una respuesta AJAX en formato JSON
        // header('Content-Type: application/json');
        echo json_encode($datosProductos);
        exit; // Detiene la ejecución del script para evitar que se agregue HTML adicional
    } else {
        // Maneja el caso en que no se proporcionó un ID de producto
        echo "No hay productos en el carrito de compra.";
    }
}

// Función para obtener datos de un producto (ejemplo)
function obtenerListProducto($productiIdList)
{
    $con = conectarBD();
    $sql = "SELECT idproducto, nombre_producto, categoria, tipomascota, precio,stock, imagen FROM producto WHERE idproducto in {$productiIdList}";
    $result = $con->query($sql);

    $productos = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }
    }

    $con->close();

    return $productos;
}

// Función para actualizar el stock de productos
function actualizarStock2($productoId, $cantidad)
{
    $con = conectarBD();

    try {
        // Iniciar una transacción
        $con->begin_transaction();

        // Llamar al procedimiento almacenado que actualiza el stock e inserta en ventas
        $sqlCallProcedure = "CALL ActualizarStockEInsertarVenta(?, ?)";
        $stmtCallProcedure = $con->prepare($sqlCallProcedure);
        $stmtCallProcedure->bind_param("ii", $productoId, $cantidad);

        if ($stmtCallProcedure->execute()) {
            // Confirmar la transacción
            $con->commit();

            $stmtCallProcedure->close();
            $con->close();
        } else {
            // Revertir la transacción en caso de error
            $con->rollback();

            echo "Error al llamar al procedimiento almacenado: " . $stmtCallProcedure->error;
            $stmtCallProcedure->close();
            $con->close();
        }
    } catch (Exception $e) {
        // Manejo de excepciones
        $con->rollback();
        echo "Error: " . $e->getMessage();
    }
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="styles/styleProductos.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">

</head>

<?php


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
// Realiza una consulta a la base de datos para obtener la información de los productos
function obtenerProductos()
{
    $con = conectarBD();
    $sql = "SELECT idproducto, nombre_producto, categoria, tipomascota, precio,stock, imagen FROM producto WHERE stock>0";
    $result = $con->query($sql);

    $productos = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }
    }

    $con->close();

    return $productos;
}


// Obtén la lista de productos
$productos = obtenerProductos();

function obtenerNombreCategoria($idCategoria)
{
    $con = conectarBD();

    $sql = "SELECT categoria FROM categorias_productos WHERE idcategorias_productos = ?";
    $stmt = $con->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $idCategoria);
        $stmt->execute();
        $stmt->bind_result($nombreCategoria);
        $stmt->fetch();
        $stmt->close();
        $con->close();
        return $nombreCategoria;
    } else {
        return "Error al obtener la categoría"; // Maneja el error adecuadamente en tu aplicación
    }
}

function obtenerNombreMascota($idMascota)
{
    $con = conectarBD();

    $sql = "SELECT mascota FROM tipomascota WHERE idtipoMascota = ?";
    $stmt = $con->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $idMascota);
        $stmt->execute();
        $stmt->bind_result($nombreMascota);
        $stmt->fetch();
        $stmt->close();
        $con->close();
        return $nombreMascota;
    } else {
        return "Error al obtener el tipo de mascota"; // Maneja el error adecuadamente en tu aplicación
    }
}
function obtenerStockProducto($idProducto)
{
    $con = conectarBD();
    $sql = "SELECT stock FROM producto WHERE idproducto = ?";
    $stmt = $con->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $idProducto);
        $stmt->execute();
        $stmt->bind_result($stock);
        $stmt->fetch();
        $stmt->close();
        $con->close();
        return $stock;
    } else {
        return "Error al obtener el stock del producto";
    }
}

?>

<body>
    <!-- Seccion Header -->
    <header class="text-center mt-3">
        <p class="h6">
            "Un rincón dedicado al amor incondicional de los peludos."
        </p>
    </header>
    <!-- Seccion Menu de navegacion -->
    <div id="nav" class="custom-nav">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid" style="background-color: #808080; height: 120px">
                <a class="navbar-brand" href="index.php"><img id="logo" src="img/logorm.png" alt="" /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        
                    <li class="nav-item ">
                            <a class="nav-link active" href="productos.php" aria-current="page">
                                Productos
                            </a>
                        </li>    
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="sobreNosotros.php">Sobre Nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="contacto.php">Contáctanos</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 pull-right">
                        <?php // En index.php
                        if (!$isLoginSuccess): ?>
                            <li class="nav-item"><a href="login.php"> <span>Iniciar Sesión</span></a></li>

                        <?php else: ?>

                            <li class="nav-item">Bienvenido
                                <?php echo $nombre ?>
                            </li>
                            <li class="nav-item" style="padding-left:10px;">
                                <!-- Botón para cerrar sesión -->
                                <form method="POST">
                                    <input type="submit" class="btn  btn-primary " name="cerrar_sesion"
                                        value="Cerrar Sesión">
                                </form>
                            <li class="nav-item"> <a href="#" id="cartButton"><img class="img-icon img-fluid"
                                        src="ico/cart2.svg" alt="" /></a></li>
                            </li>


                        <?php endif; ?>
                    </ul>

                </div>
            </div>
        </nav>
    </div>
    <!-- Sección Productos -->

    <div class="container  ">


        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <label class="m-2" for="tipoMascota">Seleccione el tipo de mascota:</label>
                <select name="tipoMascota" id="tipoMascota" style="width: 100px;">
                    <option value="">Todos</option>
                    <?php
                    // Conexión a la base de datos (ajusta las credenciales según tu configuración)
                    $conn = conectarBD();

                    // Verificar si la conexión fue exitosa
                    if ($conn->connect_error) {
                        die("Error de conexión: " . $conn->connect_error);
                    }

                    // Consulta SQL para obtener los tipos de mascotas
                    $sql = "SELECT idtipoMascota, mascota FROM tipomascota";

                    // Ejecutar la consulta
                    $result = $conn->query($sql);

                    // Generar opciones del select
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["idtipoMascota"] . "'>" . $row["mascota"] . "</option>";
                        }
                    }

                    // Cerrar la conexión
                    $conn->close();
                    ?>

                </select>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"
                        id="searchInput" />
                    <button class="btn btn-outline-dark" type="button" id="searchButton">Buscar</button>
                </form>
            </div>
        </div>

        <?php // En index.php
        if (!$isLoginSuccess): ?>
            <div class="alert alert-danger mt-4" role="alert">
                Para poder realizar compras debe haber iniciado sesion
            </div>
        <?php endif; ?>

        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true"
            id="confirmModal">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="textConfirmlabel"></h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="modal-btn-si">Si</button>
                        <button type="button" class="btn btn-primary" id="modal-btn-no">No</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            <?php foreach ($productos as $producto): ?>
                <div class="col-sm-12 col-md-6 col-lg-3  product-card "
                    data-tipomascota="<?php echo $producto['tipomascota']; ?>">
                    <div class="card mt-5 justify-content-center text-center">
                        <img src="img/products/<?php echo $producto['imagen']; ?>" class="card-img-top" alt="Producto" />
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo $producto['nombre_producto']; ?>
                            </h5>
                            <p class="card-text">Categoría:
                                <?php echo obtenerNombreCategoria($producto['categoria']); ?>
                            </p>
                            <p class="card-text">Tipo de mascota:
                                <?php echo obtenerNombreMascota($producto['tipomascota']); ?>
                            </p>
                            <p class="card-text price">Precio: $
                                <?php echo number_format($producto['precio'], 2); ?>
                            </p>

                            <?php // En index.php
                                if (!$isLoginSuccess): ?>
                                <a href="#" class="btn btn-primary disabled" data-bs-toggle="modal" data-bs-target="#myModal"
                                    data-id="<?php echo ($producto['idproducto']); ?>"
                                    data-stock="<?php echo ($producto['stock']); ?>"
                                    data-price="<?php echo $producto['precio']; ?>"
                                    data-product-image="img/products/<?php echo $producto['imagen']; ?>">Comprar</a>

                            <?php else: ?>
                                <a href="#" class="btn btn-primary cardButtonComprar" data-bs-toggle="modal"
                                    data-bs-target="#myModal" data-id="<?php echo ($producto['idproducto']); ?>"
                                    data-stock="<?php echo ($producto['stock']); ?>"
                                    data-price="<?php echo $producto['precio']; ?>"
                                    data-product-image="img/products/<?php echo $producto['imagen']; ?>">Comprar</a>

                            <?php endif; ?>


                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmar Compra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="productNameInModal"></p>
                    <p id="productPriceInModal"></p>
                    <label for="productStockInModal">Cantidad: </label>
                    <input type="number" style="width: 80px;" maxlength="2" id="productQuantityInModal">
                    <p></p>
                    <p></p>
                    <p id="productStockInModal"></p>
                    <p id="productTotalInModal"></p>

                    ¿Estás seguro de que deseas comprar este producto?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="addToCartBtn" data-product-name=""
                        data-product-price="" data-product-stock="" data-product-image="">Añadir al carrito</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmar Compra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Tu carrito de compras</h5>
                    <input type="hidden" name="currentCart" id="currentCartHidden">

                    <ul id="cartList" class="list-group">
                    </ul>

                    <div class="row mt-2">
                        <div class="col-10 text-end ">
                            <p>Total: </p>
                        </div>
                        <div class="col-2">
                            <p id="totalPriceInModal">$0.00</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="#"><button id="cartBtnComprar" type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalConfirm">Comprar</button></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmacion -->
    <div class="modal fade" id="modalConfirm" tabindex="-2" aria-labelledby="modalConfirmLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmar Carrito</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas finalizar con tu compra?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                        data-bs-target="#myModal2">Regresar</button>
                    <button type="button" id="confirmCompraCarrito" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalFactura">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Factura -->
    <div class="modal fade modal-lg" id="modalFactura" tabindex="-2" aria-labelledby="modalFacturaLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Factura de compra <i
                            class="fa-regular fa-circle-check fa-beat" style="color: #0ee15f;"></i></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3>Compra Finalizada!!</h1>
                        <table id="tableFacturacion" class="table table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th>No.</th>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <th colspan=" 4" class="text-end">Total: </th>
                                <th class="text-end"><b><span id="totalCompraSpan"></span></b></th>
                            </tfoot>
                        </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Seccion Footer -->
    <footer>
        <div class="row text-center container-contact">
            <div class="col-md-4">
                <span><i class="fas fa-phone vibrate"></i>

                    0987493979</span>
            </div>
            <div class="col-md-4">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-envelope vibrate"
                        viewBox="0 0 16 16">
                        <path
                            d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                    </svg>
                    alcidessainz99@gmail.com
                </span>
            </div>
            <div class="col-md-4 vibrate-up-down">
                <a href="https://github.com" class="no-link-style">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-github" viewBox="0 0 16 16">
                        <path
                            d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z" />
                    </svg></a>
                <a href="https://www.instagram.com" class="no-link-style">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-instagram" viewBox="0 0 16 16">
                        <path
                            d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                    </svg></a>
                <a href="https://www.whatsapp.com/?lang=es_LA" class="no-link-style">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-whatsapp" viewBox="0 0 16 16">
                        <path
                            d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                    </svg></a>
                <a href="https://www.facebook.com" class="no-link-style">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-facebook" viewBox="0 0 16 16">
                        <path
                            d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                    </svg></a>
                <a href="https://www.tiktok.com/explore" class="no-link-style">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-tiktok" viewBox="0 0 16 16">
                        <path
                            d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3V0Z" />
                    </svg></a>
            </div>
        </div>

    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

    <!-- pdfMake JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
    <script>
        $(document).ready(function () {
            // Captura el evento de presionar la tecla "Enter" en el campo de búsqueda
            $("#searchInput").keypress(function (e) {
                if (e.which == 13) { // 13 es el código de tecla "Enter"
                    e.preventDefault(); // Evita la recarga de la página
                    $("#searchButton").click(); // Simula hacer clic en el botón de búsqueda
                }
            });

            $("#searchButton").click(function () {
                var searchTerm = $("#searchInput").val().trim().toLowerCase();

                if (searchTerm === "") {
                    $(".product-card").show();
                } else {
                    $(".product-card").hide();

                    $(".product-card").each(function () {
                        var productName = $(this).find(".card-title").text().toLowerCase();
                        if (productName.includes(searchTerm)) {
                            $(this).show();
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            // Cuando cambie la selección en el select
            $("#tipoMascota").change(function () {
                var selectedTipoMascota = $(this).val();

                // Mostrar u ocultar tarjetas de producto basadas en el tipo de mascota seleccionado
                if (selectedTipoMascota === "") {
                    $(".product-card").show(); // Mostrar todas las tarjetas si se selecciona "Todos"
                } else {
                    $(".product-card").hide(); // Ocultar todas las tarjetas
                    $(".product-card[data-tipomascota='" + selectedTipoMascota + "']").show(); // Mostrar tarjetas con el tipo de mascota seleccionado
                }
            });
        });
    </script>
    <!--Configuracion del carrito -->
    <script>
        $(document).ready(function () {
            $(document).delegate('#confirmCompraCarrito', 'click', function () {


                var currentCartHidden = $("#currentCartHidden").val().replace(/^,/, '');
                var currentCartValues = currentCartHidden.split(","); //id-cant

                $.each(currentCartValues, function (index, producto) {

                    var productoid = producto.split('-')[0];
                    var cantidad = parseInt(producto.split('-')[1]);

                    $.ajax({
                        type: "POST", // Puedes cambiarlo a "GET" si prefieres
                        url: "productos.php", // Ruta al script PHP que contiene la función actualizarStock2
                        data: { productoId: productoid, cantidad: cantidad },
                        error: function (xhr, status, error) {
                            console.error("Error en la llamada AJAX: " + error);
                        }
                    });
                });
            })

            var tableFacturacion = $('#tableFacturacion').DataTable({
                dom: 'B',
                buttons: [
                    {
                        text: 'Descargar PDF',
                        extend: 'pdfHtml5',
                        filename: 'Factura Compra',
                        // Para anadir el footer al pdf de factura
                        customize: function (doc) {
                            // Agregar el contenido del tfoot al PDF
                            var tfoot = $(doc.content).find('tfoot')[0];
                            var tfootData = [];

                            // Recorre las celdas del tfoot y agrega los datos al array tfootData
                            $(tfoot).find('tr').each(function () {
                                var rowData = [];
                                $(this).find('th, td').each(function () {
                                    rowData.push($(this).text());
                                });
                                tfootData.push(rowData);
                            });

                            // Agrega los datos del tfoot al cuerpo del PDF
                            for (var i = 0; i < tfootData.length; i++) {
                                doc.content[1].table.body.push(tfootData[i]);
                            }
                        }
                    }
                ],
                "columnDefs": [
                    { "targets": 4, "className": "text-end" }, // Alinea la tercera columna (Precio) a la derecha
                    { "targets": 2, "className": "text-end" },
                    { "targets": 0, "className": "text-end" },
                    { "targets": 3, "className": "text-end" },
                ]
            }
            );

            $("#cartButton").click(function () {
                var currentCartHidden = $("#currentCartHidden").val().replace(/^,/, '');
                var currentCartValues = currentCartHidden.split(","); //id-cant

                if (currentCartValues[0] == undefined || currentCartValues[0] == '' || currentCartValues.length == 0) {
                    $("#cartList").empty();
                    var listItem = $(`<li>`).addClass("list-group-item");
                    // Construye el contenido del <li> con los datos del producto
                    var contenido = `
                                <div class="alert alert-danger" role="alert">
                                No tiene elementos de compra en tu carrito!!!
                                </div>
                            `;
                    listItem.html(contenido);
                    // Agrega el <li> a la lista <ul>
                    $("#cartList").append(listItem);

                    $("#myModal2").modal("show");

                    HideShowCartBtnComprar(false);

                    return false;
                }

                HideShowCartBtnComprar(true);

                var productIdList = '(';

                var currentCart = [];

                $.each(currentCartValues, function (index, producto) {

                    var productoid = producto.split('-')[0];
                    if (productoid > 0) {

                        productIdList += `${productoid},`;

                        // Crea un objeto de producto y agrega sus propiedades
                        var productoObj = {
                            productoid: productoid, // ID del producto
                            cantidad: parseInt(producto.split('-')[1]) // Cantidad como número entero
                        };

                        // Agrega el objeto de producto al arreglo de productos
                        currentCart.push(productoObj);
                    }
                });

                productIdList = productIdList.replace(/,$/, ")");

                function buscarProductoPorId(productoid) {
                    return currentCart.find(function (producto) {
                        return producto.productoid === productoid;
                    });
                }

                // Realizar la solicitud AJAX
                $.ajax({
                    type: "POST",
                    url: "productos.php",
                    data: { productIdList: productIdList }, // Envía el ID del producto al servidor
                    success: function (response) {

                        var productos = JSON.parse(response);
                        // Limpia el contenido de la lista <ul> con jQuery
                        $("#cartList").empty();
                        var totalInCart = 0;

                        var contador = 0;


                        tableFacturacion.clear().draw();

                        // Itera a través de los productos y agrégalos a la lista con jQuery
                        $.each(productos, function (index, producto) {
                            var listItem = $(`<li id='liproducto_${producto.idproducto}'>`).addClass("list-group-item");

                            // Busca la cantidad del producto por su ID en el arreglo currentCart
                            var cantidadProducto = buscarProductoPorId(producto.idproducto).cantidad;

                            // Construye el contenido del <li> con los datos del producto
                            var contenido = `
                                <div class="row media">
                                <div class="col-sm-12 col-md-2 col-lg-2">
                                    <img src="img/products/${producto.imagen}" class="align-self-start mr-3" alt="Imagen del producto" style="max-width: 50px;">
                                    </div>
                                    <div class="col-sm-12 col-md-10 col-lg-10 media-body d-flex align-items-left">
                                        <div>
                                            <h5 class="mt-0">${producto.nombre_producto}</h5>
                                            <p>Precio: $${producto.precio}              Cantidad: ${cantidadProducto}</p>                                           
                                            <p >Subtotal: $${(producto.precio * cantidadProducto).toFixed(2)}</p>
                                            <button class="btn btn-outline-danger deleteButton text-end" data-subtotal="${producto.precio * cantidadProducto}" data-idproducto="${producto.idproducto}" style="marging-left:30px;" type="button">Eliminar</button>
                                        </div>
                                    </div>
                                </div>
                            `;

                            listItem.html(contenido);

                            totalInCart += producto.precio * cantidadProducto;

                            // Agrega el <li> a la lista <ul>
                            $("#cartList").append(listItem);

                            tableFacturacion.row.add([
                                contador += 1,
                                producto.nombre_producto,
                                `$${producto.precio}`,
                                cantidadProducto,
                                `$${(producto.precio * cantidadProducto).toFixed(2)}`
                            ]).draw(false);

                            $("#totalCompraSpan").text(`$${(totalInCart).toFixed(2)}`)

                        });

                        $("#totalPriceInModal").text(`$${(totalInCart).toFixed(2)}`);

                        $("#myModal2").modal("show");



                    },
                    error: function () {
                        // Manejar errores si los hay
                        alert("Hubo un error en la solicitud AJAX.");
                    }


                });
            });
        });

    </script>
    <script>

        const buyButtons = document.querySelectorAll('.cardButtonComprar');
        let quantityInput = document.querySelector('.modal input[type="number"]');
        const productPriceInModal = document.getElementById('productPriceInModal');
        const productTotalInModal = document.getElementById('productTotalInModal');

        let cart = [];

        // Función para calcular y mostrar el total del precio en el modal


        buyButtons.forEach(button => {
            button.addEventListener('click', function () {
                const card = button.closest('.card');
                const productName = card.querySelector('.card-title').textContent;
                const productStock = button.getAttribute('data-stock');
                const productPrice = parseFloat(button.getAttribute('data-price'));

                // Actualiza el valor máximo del campo de entrada con el stock disponible
                console.log(`Stock disponible: ${productStock}`);
                quantityInput.max = productStock;

                document.getElementById('productNameInModal').textContent = `Producto: ${productName}`;
                productPriceInModal.textContent = `Precio: $${productPrice}`;
                document.getElementById('productStockInModal').textContent = `Quedan: ${productStock} productos`;

                // Establece el valor del campo de entrada a 1 cuando se abre el modal
                quantityInput.value = 1;

                // Actualiza el total inicial
                const total = productPrice;
                productTotalInModal.textContent = `Total: $${total.toFixed(2)}`;
            });
        });

        // Actualiza el total en función de la cantidad ingresada
        quantityInput.addEventListener('input', function () {
            let enteredValue = parseInt(quantityInput.value);
            const productStock = parseInt(quantityInput.max);

            // Asegurarse de que el valor no sea menor que 0
            if (enteredValue < 0) {
                enteredValue = 0;
            }

            // Asegurarse de que el valor no sea mayor que el stock
            if (enteredValue > productStock) {
                enteredValue = productStock;
            }

            quantityInput.value = enteredValue;

            const productPrice = parseFloat(productPriceInModal.textContent.replace('Precio: $', ''));

            const total = enteredValue * productPrice;
            productTotalInModal.textContent = isNaN(total) ? `Total: $0.00` : `Total: $${total.toFixed(2)}`;
        });


        // Variable global para el total de la compra
        let totalCompra = 0.00;

        document.addEventListener('DOMContentLoaded', function () {

            // Función para agregar un producto al carrito
            function addToCart(idproducto, cantidad) {

                // Agrega el producto seleccionado al array del carrito

                var resultado = $.grep(cart, function (producto) {
                    return producto.idproducto === idproducto;
                });

                if (resultado.length > 0) {
                    for (var i = 0; i < cart.length; i++) {
                        if (cart[i].idproducto === idproducto) {
                            cart.splice(i, 1); // Elimina el elemento en la posición i
                            break; // Rompe el bucle una vez que se elimina el elemento
                        }
                    }
                }

                cart.push({
                    idproducto: idproducto,
                    cantidad: cantidad
                });

                let productList = '';

                $.each(cart, function (index, producto) {
                    productList += `,${producto.idproducto}-${producto.cantidad}`;
                });

                $("#currentCartHidden").val(productList);
            }

            // Función para eliminar un producto del carrito
            function removeFromCart(productName) {

                // Encuentra el índice del producto en el carrito
                const index = cart.findIndex(product => product.nombre === productName);

                // Si se encuentra el producto, elimínalo del carrito
                if (index !== -1) {
                    cart.splice(index, 1);
                    displayCart();
                    updateTotalPrice();
                }
            }


            // Función para calcular y mostrar el total de la compra
            function updateTotalPrice() {
                const totalPriceElement = document.getElementById('totalPriceInModal');

                // Calcula el total sumando los precios de los productos en el carrito
                let total = 0.00;
                cart.forEach(function (product) {
                    total += product.precio;
                });

                // Actualiza el elemento HTML con el total calculado

                totalPriceElement.textContent = isNaN(total) ? `0.00` : `$${total.toFixed(2)}`;
            }



            // Al abrir el modal, configura los datos del producto en el botón "Añadir al carrito"
            document.getElementById('myModal').addEventListener('show.bs.modal', function (event) {

                const button = event.relatedTarget;

                const idproducto = $(button).attr("data-id");

                const card = button.closest('.card');
                const productName = card.querySelector('.card-title').textContent;
                const productPrice = parseFloat(card.querySelector('.price').textContent.replace('Precio: $', ''));
                const productStock = parseInt(button.getAttribute('data-product-stock'));

                const productImage = button.getAttribute('data-product-image');

                const addToCartBtn = document.getElementById('addToCartBtn');
                addToCartBtn.setAttribute('data-product-idproducto', idproducto);
                addToCartBtn.setAttribute('data-product-name', productName);
                addToCartBtn.setAttribute('data-product-price', productPrice);
                addToCartBtn.setAttribute('data-product-stock', productStock);
                addToCartBtn.setAttribute('data-product-image', productImage);
                console.log(`productImage: ${productImage}`);

            });

            // Agrega un evento clic al botón "Añadir al carrito" en el modal
            const addToCartBtn = document.getElementById('addToCartBtn');
            addToCartBtn.addEventListener('click', function () {

                idproducto = addToCartBtn.getAttribute('data-product-idproducto');
                productName = addToCartBtn.getAttribute('data-product-name');
                productPrice = parseFloat(addToCartBtn.getAttribute('data-product-price'));
                productStock = addToCartBtn.getAttribute('data-product-stock');
                productImage = addToCartBtn.getAttribute('data-product-image');
                quantityInput = document.getElementById('productQuantityInModal');
                quantity = parseInt(quantityInput.value);
                console.log(`Cantidad ingresada: ${quantity}`);

                if (quantity > productStock) {
                    alert('La cantidad ingresada es mayor que el stock disponible.');

                } else {
                    // Agregar el producto al carrito la cantidad de veces especificada

                    addToCart(idproducto, quantity);

                    // Cerrar el modal después de agregar los productos al carrito
                    $('#myModal').modal('hide');
                }
                updateTotalPrice()
            });

        });


        $(document).delegate(".deleteButton", "click", function () {

            var idproducto = $(this).data("idproducto");
            var subtotal = $(this).data("subtotal");

            bootbox.confirm({
                size: 'medium',
                closeButton: false,
                message: "¿Estás seguro de que deseas eliminar este producto?",
                callback: function (result) {
                    if (result === true) {
                        deleteProdcutoFromCart(idproducto, subtotal);
                    }
                },
                error: function (error) {
                    bootbox.alert({
                        size: 'medium',
                        title: 'Error al borrar ',
                        message: '<div class="alert alert-dismissible alert-danger">' +
                            '<strong>No se pudo eliminar el producto de la lista</strong>  ' + error.statusText +
                            '</div>'
                    });
                }
            });
        });


        var deleteProdcutoFromCart = function (idproducto, subtotal) {


            for (var i = 0; i < cart.length; i++) {
                if (cart[i].idproducto == idproducto) {
                    cart.splice(i, 1); // Elimina el elemento en la posición i
                    break; // Rompe el bucle una vez que se elimina el elemento
                }
            }

            let productList = '';

            $.each(cart, function (index, producto) {
                productList += `,${producto.idproducto}-${producto.cantidad}`;
            });

            $("#currentCartHidden").val(productList);

            $(`#liproducto_${idproducto}`).hide(300);

            var currentTotal = $("#totalPriceInModal").text().replace(/[^\d.]/g, '');

            currentTotal -= subtotal;

            $("#totalPriceInModal").text(`$${(currentTotal).toFixed(2)}`);

            if (cart.length == 0) {
                var listItem = $(`<li>`).addClass("list-group-item");
                // Construye el contenido del <li> con los datos del producto
                var contenido = `
                                <div class="alert alert-danger" role="alert">
                                No tiene elementos de compra en tu carrito!!!
                                </div>
                            `;
                listItem.html(contenido);
                // Agrega el <li> a la lista <ul>
                $("#cartList").append(listItem);

                HideShowCartBtnComprar(false);

            }

        }

        var HideShowCartBtnComprar = (show) => {

            $("#cartBtnComprar").hide();

            if (show)
                $("#cartBtnComprar").show();

        }

    </script>


</body>


</html>