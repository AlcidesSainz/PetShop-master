<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registro</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Agrega los estilos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="styles/styleRegistro.css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <style>
        body {
            overflow: hidden;
        }

        #gato-corriendo {
            z-index: -1;
            position: absolute;
            right: 0;
            /* Inicialmente en la parte derecha */
            top: 50%;
            /* Ajusta la posición vertical según tus necesidades */

        }
    </style>
</head>

<body>
    <!--Container Registro -->
    <div class="container mb-5">
        <?php
        // Variables para almacenar los valores de los campos
        $nombre = '';
        $correo = '';
        // Verifica si el formulario se ha enviado
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Recopila los datos del formulario
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $contrasena = $_POST['contrasena'];
            $contrasenaRepetida = $_POST['contrasenaRepetida'];

            // Verifica si las contraseñas coinciden
            if ($contrasena == $contrasenaRepetida) {
                // Encripta la contraseña
                $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);
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
                $sql = "INSERT INTO usuarios (nombre, correo, contrasena) VALUES ('$nombre', '$correo', '$hashed_password')";

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
            } else {
                echo '<div id="registroFallido" class="alert alert-danger" role="alert">
        Las contraseñas no coinciden. Por favor, verifícalas.
    </div>';
                ;
            }
        }
        ?>

        <div class="registro-container mt-5" id="registro-container">
            <div class="registro-header">
                <h2>Registro de Usuario</h2>
            </div>
            <form method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Nombre" required name="nombre" id="nombre"
                        value="<?php echo $nombre; ?>" />
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Correo Electrónico" required name="correo"
                        id="correo" value="<?php echo $correo; ?>" />
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Contraseña" required name="contrasena"
                        id="contrasena" />
                    <small id="contrasena-error" class="text-danger"></small>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Repita la Contraseña" required
                        name="contrasenaRepetida" id="contrasena" />
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
        <img id="gato-corriendo" src="img/gato cco.gif" style="width: 80px;">
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Función para validar la contraseña
            function validarContrasena(contrasena) {
                // Define las expresiones regulares para cada requisito
                const regexMayuscula = /[A-Z]/;
                const regexNumero = /[0-9]/;
                const regexCaracterEspecial = /[$&+,:;=?@#|'<>.^*()%!-]/;

                // Verifica si la contraseña cumple con los requisitos
                const cumpleRequisitos =
                    regexMayuscula.test(contrasena) &&
                    regexNumero.test(contrasena) &&
                    regexCaracterEspecial.test(contrasena);

                return cumpleRequisitos;
            }

            // Agrega un evento al campo de contraseña para validar cuando cambia
            $("#contrasena").on("input", function () {
                const contrasena = $(this).val();
                const esValida = validarContrasena(contrasena);

                // Muestra un mensaje de error si la contraseña no cumple los requisitos
                if (!esValida) {
                    $("#contrasena-error").text(
                        "La contraseña debe contener al menos una letra mayúscula, un número y un carácter especial."
                    );
                } else {
                    $("#contrasena-error").text("");
                }
            });

            // Agrega un evento al formulario para prevenir su envío si la contraseña no es válida
            $("form").submit(function (event) {
                const contrasena = $("#contrasena").val();
                const esValida = validarContrasena(contrasena);

                if (!esValida) {
                    event.preventDefault();
                    $("#contrasena-error").text(
                        "La contraseña debe contener al menos una letra mayúscula, un número y un carácter especial."
                    );
                }
            });
        });
    </script>

    <script>
        // Función para ocultar la alerta después de 2 segundos
        function ocultarAlerta() {
            const registroExitoso = document.getElementById('registroExitoso');
            const registroFallido = document.getElementById('registroFallido');

            if (registroExitoso) {
                setTimeout(function () {
                    registroExitoso.style.display = 'none';
                }, 2000);
            }

            if (registroFallido) {
                setTimeout(function () {
                    registroFallido.style.display = 'none';
                }, 2000);
            }
        }

        // Llama a la función para ocultar la alerta
        ocultarAlerta();
    </script>


    <!-- Script para activar la animación al cargar la página -->
    <script>
        // Espera a que se cargue el documento completamente
        document.addEventListener('DOMContentLoaded', function () {
            // Selecciona la imagen por su ID
            const imagen = document.getElementById('gato-corriendo');

            // Define la animación utilizando Anime.js
            anime({
                targets: imagen,          // Elemento a animar (nuestra imagen)
                translateX: '-2000px',     // Mueve la imagen 100% hacia la izquierda (fuera de la pantalla)
                duration: 20000,          // Duración de la animación en milisegundos (2 segundos)
                easing: 'easeOutQuad',   // Tipo de aceleración de la animación (puedes ajustarlo)
                loop: true,              // No se repite la animación
            });
        });
    </script>

    <!-- Agrega los scripts de Bootstrap y jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
</body>

</html>