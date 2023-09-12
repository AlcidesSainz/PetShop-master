<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Agrega los estilos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="styles/styleLogin.css" />
    <link rel="stylesheet" href="styles/styleRegistro.css" />
</head>

<body>

    <!--Container Registro -->
    <div class="container mt-5">
        <div id="registroExitoso">
            <?php
            $host = "localhost";
            $port = 3306;
            $socket = "";
            $user = "root";
            $password = "root";
            $dbname = "pet_shop";

            $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
                or die('Could not connect to the database server' . mysqli_connect_error());

            //$con->close();


            // Verifica si la conexión tuvo éxito

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Recopila los datos del formulario
                $nombre = $_POST['nombre'];
                $correo = $_POST['correo'];
                $contrasena = $_POST['contrasena'];

                // Realiza la conexión a la base de datos ( reemplaza con tus propias credenciales )
                $servername = 'localhost';
                $username = 'root';
                $password = 'root';
                $database = 'pet_shop';

                $conexion = new mysqli($servername, $username, $password, $database);
                if ($conexion->connect_error) {
                    die('Error de conexión: ' . $conexion->connect_error);
                }

                // Inserta los datos en la tabla de usuarios ( reemplaza 'nombre_tabla' con el nombre de tu tabla )
                $sql = "INSERT INTO usuarios (nombre, correo, contrasena) VALUES ('$nombre', '$correo', '$contrasena')";

                if ($conexion->query($sql) === TRUE) {
                    echo '<div class="alert alert-success" role="alert">
        Registro Exitoso. Redireccionando...
      </div>';
                    // Redirecciona al usuario después de 2 segundos (cambia la URL a la que desees redirigir)
                    echo '<script>
            setTimeout(function(){
              window.location.href = "login.php";
            }, 2000);
          </script>';
                } else {
                    echo 'Error al registrar: ' . $conexion->error;
                }
                // Cierra la conexión a la base de datos
                $conexion->close();
            }
            ?>
        </div>
        <div class="registro-container" id="registro-container">
            <div class="registro-header">
                <h2>Registro de Usuario</h2>
            </div>
            <form method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Nombre" required name="nombre" id="nombre" />
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Correo Electrónico" required name="correo" id="correo" />
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Contraseña" required name="contrasena" id="contrasena" />
                </div>
                <p class="text-center mt-3">
                    <a href="login.php" id="regresar-link">Regresar al inicio de sesión</a>
                </p>
                <!-- Agrega más campos de registro si es necesario -->
                <button type="submit" class="btn btn-registro btn-block">
                    Registrarse
                </button>

            </form>
        </div>
    </div>




    <!-- Agrega los scripts de Bootstrap y jQuery (si es necesario) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>