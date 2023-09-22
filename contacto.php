<?php
include("config.php");

// Luego, puedes utilizar las variables de configuración en tu conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

session_start();
// $_SESSION['loginSuccess'] = $loginSuccess; // Puedes guardar otros datos en la sesión según tus necesidades
// $_SESSION['id'] = $id;
// $_SESSION['nombre'] = $nombre;
// $_SESSION['email'] = $email;
// $_SESSION['roleId'] = $roleId;
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
    <title>Contáctanos</title>
    <link rel="stylesheet" href="styles/styleContacto.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="styles/style.css">

</head>

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
                            <a class="nav-link active" aria-current="page" href="#">Contáctanos</a>
                        </li>
                        <!-- Verifica si el usuario es administrador antes de mostrar el enlace -->
                        <?php // En index.php
                        if ($IsAdmin): ?>
                            <li class="nav-item"><a href="ingresarProducto.php" class="nav-link active"
                                    aria-current="page">Administrar</a></li>
                        <?php endif; ?>
                    </ul>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 pull-right">
                        <?php // En index.php
                        if (!$isLoginSuccess): ?>
                            <li class="nav-item"><a href="login.php"> <span>Iniciar Sesión</span></a></li>

                        <?php else: ?>
                            <li class="nav-item"><small>Bienvenido
                                    <?php echo $nombre ?>
                                </small></li>
                            <li class="nav-item" style="padding-left:10px;">
                                <!-- Botón para cerrar sesión -->
                                <form method="POST">
                                    <input type="submit" class="btn btn-sm btn-primary" name="cerrar_sesion"
                                        value="Cerrar Sesión">
                                </form>
                            </li>

                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="mt-5 text-center">
        <h1>Contáctanos</h1>
        <span>"Estamos aquí para ayudarte. ¡No dudes en ponerte en contacto con nosotros"</span>
    </div>
    <div class="row">
        <div class="col-md-6 mx-auto mb-5 mt-5">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Procesar el formulario aquí si se ha enviado
                $nombre = $_POST['nombre'];
                $email = $_POST['email'];
                $mensaje = $_POST['mensaje'];

                include("config.php");

                // Luego, puedes utilizar las variables de configuración en tu conexión a la base de datos
                $conn = new mysqli($servername, $username, $password, $database);

                if ($conn->connect_error) {
                    die('Error de conexión: ' . $conn->connect_error);
                }


                $sql = "INSERT INTO comentarios (nombre, email, comentario) VALUES ('$nombre', '$email', '$mensaje')";

                if (mysqli_query($conn, $sql)) {
                    echo "<div class='alert alert-success'>¡Tu mensaje se ha enviado con éxito!</div>";
                    echo "<meta http-equiv='refresh' content='1;url=contacto.php'>";
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</div>";
                }

                mysqli_close($conn);
            }
            ?>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="nombre" class="font-weight-bold">Nombre:*</label>
                    <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Tu nombre" required>
                </div>
                <div class="form-group">
                    <label for="email" class="font-weight-bold">Correo Electrónico:*</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Tu correo electrónico"
                        required>
                </div>
                <div class="form-group">
                    <label for="mensaje" class="font-weight-bold">Mensaje:*</label>
                    <textarea class="form-control" name="mensaje" id="mensaje" rows="4"
                        placeholder="Escribe tu mensaje aquí" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-3">Enviar Mensaje</button>
            </form>
        </div>
    </div>


    <div class="container container-comments mt-5 mb-5">
        <div class="row">
            <div class="mb-3 col-lg-6">
                <h3>¿Donde nos ubicamos?</h3>
                <p>Av.10 de agosto y República. <br>Quito,Ecuador</p>
                <div id="mapa"></div>

                <script>
                    //Mapa de google map
                    function inicializarMapa() {
                        var ubicacion = {
                            lat: -0.18421921761522256,
                            lng: -78.490830982687,
                        }; // Reemplaza con las coordenadas de tu ubicación
                        var mapa = new google.maps.Map(document.getElementById("mapa"), {
                            center: ubicacion,
                            zoom: 15, // Nivel de zoom del mapa
                        });

                        var marcador = new google.maps.Marker({
                            position: ubicacion,
                            map: mapa,
                            title: "Ubicación de ejemplo", // Título del marcador (opcional)
                        });
                    }
                </script>
            </div>

            <div class="mb-3 mt-3 col-lg-6 ">
                <img src="img/logorm.png" style="width: 400px; height:auto; align-items: center;">
            </div>
        </div>
    </div>
    <div class="container container-comments mt-5 mb-5">
        <h2>Comentarios de nuestros clientes:</h2>
        <div id="comentarios"></div>
    </div>
    <!-- Seccion Footer -->
    <div class="row text-center container-contact">
        <div class="col-md-4">
            <span><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-telephone vibrate"
                    viewBox="0 0 16 16">
                    <path
                        d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                </svg>
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
            <a href="https://github.com/AlcidesSainz?tab=repositories" target="_blank" class="no-link-style">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-github"
                    viewBox="0 0 16 16">
                    <path
                        d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z" />
                </svg></a>
            <a href="https://www.instagram.com" class="no-link-style">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-instagram" viewBox="0 0 16 16">
                    <path
                        d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                </svg></a>
            <a href="https://www.facebook.com" class="no-link-style">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-facebook" viewBox="0 0 16 16">
                    <path
                        d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                </svg></a>
            <a href="https://www.tiktok.com/explore" class="no-link-style">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tiktok"
                    viewBox="0 0 16 16">
                    <path
                        d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3V0Z" />
                </svg></a>
        </div>
    </div>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4tpSjs5JX1kBLs2J6lhjMyAu4zPitQP0&callback=inicializarMapa"
        async defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
    <script src="script.js"></script>

    <script>
        $(document).ready(function () {
            // Realizar una solicitud AJAX para obtener los datos desde get_comments.php
            debugger
            $.ajax({
                url: '/php_functions/get_comments.php',
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Limpiar el contenido actual del elemento #comentarios
                    $('#comentarios').empty();

                    // Iterar a través de los datos y agregarlos al elemento #comentarios
                    $.each(data, function (index, item) {
                        $('#comentarios').append('<div class="container container-comments mt-5 mb-5 card-Comments" id="comentarios" style="background-color:#DCF3E9;"><p><strong>Nombre: </strong>' + item.nombre + '</p><p><strong>Comentario: </strong>"' + item.comentario + '"</p>        </div>');
                    });
                },
                error: function (error) {
                    console.error('Error al obtener los comentarios: ' + error.responseText);
                }
            });
        });
    </script>

</body>

</html>