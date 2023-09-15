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
    $sql = "SELECT nombre_producto, categoria, tipomascota, precio,stock, imagen FROM producto";
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
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
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
                    <a href="#"><img class="img-icon img-fluid" data-bs-toggle="modal" data-bs-target="#myModal2"
                            src="ico/cart2.svg" alt="" /></a>
                </div>
            </div>
        </nav>
    </div>
    <!-- Sección Productos -->
    <div class="container">
        <div class="row">
            <?php foreach ($productos as $producto): ?>
                <div class="col-3">
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
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal"
                                data-stock="<?php echo ($producto['stock']); ?>"
                                data-price="<?php echo $producto['precio']; ?>"
                                data-product-image="img/products/<?php echo $producto['imagen']; ?>">Comprar</a>
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
                    <ul id="cartList" class="list-group">
                        <!-- Cart items will be added here -->
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
                    <button type="button" class="btn btn-primary">Comprar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
    <!-- Agrega el script después del modal y antes de cerrar la etiqueta </body> -->

    <script>

        const buyButtons = document.querySelectorAll('.btn.btn-primary[data-bs-toggle="modal"]');
        let quantityInput = document.querySelector('.modal input[type="number"]');
        const productPriceInModal = document.getElementById('productPriceInModal');
        const productTotalInModal = document.getElementById('productTotalInModal');

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
            productTotalInModal.textContent = `Total: $${total.toFixed(2)}`;
        });


        // Variable global para el total de la compra
        let totalCompra = 0.00;

        document.addEventListener('DOMContentLoaded', function () {
            // JavaScript
            const cart = []; // Array to store selected products
            function updateTotalPrice() {
                const totalPriceElement = document.getElementById('totalPriceInModal');

                // Calcular el total del precio sumando los precios de los productos en el carrito
                let total = 0.00;
                cart.forEach(function (product) {
                    total += product.precio;
                });

                // Actualizar el elemento HTML con el total calculado
                totalPriceElement.textContent = `$${total.toFixed(2)}`;
                console.log(totalPriceElement)
            }
            // Function to add a product to the cart
            function addToCart(productName, productPrice, productImage) {
                // Add the selected product to the cart array
                cart.push({
                    nombre: productName,
                    precio: productPrice,
                    imagen: productImage
                });
                // Update the cart display
                displayCart();
            }
            // Function to display the cart in myModal2
            function displayCart() {
                const cartList = document.getElementById('cartList');
                cartList.innerHTML = ''; // Clear previous cart items

                cart.forEach(function (product) {
                    const cartItem = document.createElement('li');
                    cartItem.className = 'list-group-item';
                    console.log(product['imagen'])
                    // Create the cart item content
                    cartItem.innerHTML = `
                <div class="row">
                    <div class="col-2">
                        <img src="${product['imagen']}" alt="Producto" class="img-fluid">
                      
                    </div>
                    <div class="col-6">
                        <p>${product['nombre']}</p>
                        
                    </div>
                    <div class="col-4 text-end">
                        <p>Precio: $${product['precio'].toFixed(2)}</p>
                    </div>
                </div>`;
                    cartList.appendChild(cartItem);
                });
            }


            // Al abrir el modal, configura los datos del producto en el botón "Añadir al carrito"
            document.getElementById('myModal').addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const card = button.closest('.card');
                const productName = card.querySelector('.card-title').textContent;
                const productPrice = parseFloat(card.querySelector('.price').textContent.replace('Precio: $', ''));
                const productStock = parseInt(button.getAttribute('data-product-stock'));

                const productImage = button.getAttribute('data-product-image');

                const addToCartBtn = document.getElementById('addToCartBtn');
                addToCartBtn.setAttribute('data-product-name', productName);
                addToCartBtn.setAttribute('data-product-price', productPrice);
                addToCartBtn.setAttribute('data-product-stock', productStock);
                addToCartBtn.setAttribute('data-product-image', productImage);
                console.log(`productImage: ${productImage}`);


            });

            // Agrega un evento clic al botón "Añadir al carrito" en el modal
            const addToCartBtn = document.getElementById('addToCartBtn');
            addToCartBtn.addEventListener('click', function () {
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
                    for (let i = 0; i < quantity; i++) {
                        addToCart(productName, productPrice, productImage);
                    }

                    // Cerrar el modal después de agregar los productos al carrito
                    $('#myModal').modal('hide');
                }
                updateTotalPrice()
            });

        });


    </script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</body>


</html>