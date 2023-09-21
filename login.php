<?php
include("config.php");

// Luego, puedes utilizar las variables de configuración en tu conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
  die('Error de conexión: ' . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- Agrega los estilos CSS de Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="styles/styleLogin.css" />

  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">

  <style>
    body {
      overflow: hidden;
    }

    #perro-corriendo {
      position: absolute;
      z-index: -1;
      left: -100px;
      /* Posición inicial fuera de la pantalla */
      top: 50%;
      /* Ajusta la posición vertical según tus necesidades */
    }
  </style>
</head>

<body>

  <div class="container mt-5">
    <div id="login-container" class="login-container">
      <div class="login-header">
        <h2>Iniciar Sesión</h2>
      </div>
      <form method="POST">
        <div class="form-group">
          <input name="email" type="email" class="form-control" placeholder="Correo Electrónico" required />
        </div>
        <div class="form-group">
          <input name="contrasena" type="password" class="form-control" placeholder="Contraseña" required />
        </div>
        <a class="registro-link" href="registro.php" id="registro-link">¿No registrado aún? Regístrate</a>
        <p class="text-center mt-3"></p>
        <button type="submit" class="btn btn-login btn-block">
          Ingresar
        </button>
      </form>
    </div>
  </div>
  <!-- Modal para mostrar el mensaje de inicio de sesión -->
  <div class="modal" id="loginModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Inicio de sesion</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p id="loginMessage">Mensaje de inicio de sesión</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <img id="perro-corriendo" src="img/perro corriendo.gif" style="width: 100px; height: auto;">
  <!-- Script para activar la animación al cargar la página -->
  <script>
    // Espera a que se cargue el documento completamente
    document.addEventListener('DOMContentLoaded', function () {
      // Selecciona la imagen por su ID
      const imagen = document.getElementById('perro-corriendo');

      // Define la animación utilizando Anime.js
      anime({
        targets: imagen,          // Elemento a animar (nuestra imagen)
        translateX: '2000px',     // Mueve la imagen 200px hacia la derecha
        duration: 20000,          // Duración de la animación en milisegundos (2 segundos)
        easing: 'easeOutQuad',   // Tipo de aceleración de la animación (puedes ajustarlo)
        loop: true,              // Repite la animación
      });
    });
  </script>

  <!-- Agrega los scripts de Bootstrap y jQuery (si es necesario) -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

</body>

</html>

<?php
$loginSuccess = false; // Variable para verificar si el inicio de sesión fue exitoso
// Verificar si se enviaron datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $contrasena = $_POST["contrasena"];
  $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

  // Consulta SQL para obtener la contraseña hasheada del usuario

  // Consulta SQL preparada
  $stmt = $conn->prepare("SELECT id, nombre, email, contrasena, roleId FROM usuarios WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $contrasenaHash = $row['contrasena'];
    $id = $row["id"];
    $nombre = $row["nombre"];
    $roleId = $row['roleId'];

    if (password_verify($contrasena, $contrasenaHash)) {
      // Inicio de sesión exitoso
      $loginSuccess = true;
      session_start();
      $_SESSION['loginSuccess'] = $loginSuccess;
      $_SESSION['id'] = $id;
      $_SESSION['nombre'] = $nombre;
      $_SESSION['email'] = $email;
      $_SESSION['roleId'] = $roleId;

      header("Location: index.php");
      exit();
    } else {
      // Contraseña incorrecta
      $loginSuccess = false;
    }
  } else {
    // Usuario no encontrado
    $loginSuccess = false;
  }

  // Cerrar la conexión a la base de datos
  $conn->close();
}
?>

<!-- JavaScript para mostrar el modal solo después de enviar el formulario -->
<script>
  $(document).ready(function () {
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if ($loginSuccess) {
        echo "$('#loginMessage').text('Inicio de sesión exitoso');";

        // Redirige al usuario a index.php después de cerrar el modal
        echo "$('#loginModal').on('hidden.bs.modal', function () { window.location.href = 'index.php'; });";
      } else {
        echo "$('#loginMessage').text('Inicio de sesión fallido. Verifique sus credenciales.');";
      }
      echo "$('#loginModal').modal('show');";
    }
    ?>
  });
</script>