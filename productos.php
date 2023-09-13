<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="styles/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="styles/styleProductos.css">

</head>
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
// Realiza una consulta a la base de datos para obtener la información de los productos
function obtenerProductos()
{
    $con = conectarBD();
    $sql = "SELECT nombre_producto, categoria, tipomascota, precio, imagen FROM producto";
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
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Productos
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Productos para perros</a></li>
                                <li><a class="dropdown-item" href="#">Productos para gatos</a></li>
                                <li><a class="dropdown-item" href="#">Productos para peces</a></li>
                                <li><a class="dropdown-item" href="#">Productos para roedores</a></li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Todos los productos</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Sobre Nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Contactanos</a>
                        </li>
                    </ul>

                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                        <button class="btn btn-outline-dark" type="submit">Buscar</button>
                    </form>

                    <a href="login.php"><img class="img-icon img-fluid" src="ico/person-circle.svg" alt="" /></a>
                    <a href=""><img class="img-icon img-fluid" src="ico/cart2.svg" alt="" /></a>
                </div>
            </div>
        </nav>
    </div>
    <!-- Seccion Productos -->
    <div class="container">
        <div class="row">
            <?php foreach ($productos as $producto) : ?>
                <div class="col-3">
                    <div class="card mt-5 justify-content-center text-center">
                        <img src="img/products/<?php echo $producto['imagen']; ?>" class="card-img-top" alt="Producto" />
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $producto['nombre_producto']; ?></h5>
                            <p class="card-text">Categoría: <?php echo obtenerNombreCategoria($producto['categoria']); ?></p>
                            <p class="card-text">Tipo de mascota: <?php echo obtenerNombreMascota($producto['tipomascota']); ?></p>
                            <p class="card-text">Precio: $<?php echo $producto['precio']; ?></p>
                            <a href="#" class="btn btn-primary">Comprar</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
</body>

</html>