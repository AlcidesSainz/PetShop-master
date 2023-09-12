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
  <div class="container mt-5">
    <div id="login-container" class="login-container">
      <div class="login-header">
        <h2>Iniciar Sesión</h2>
      </div>
      <form method="POST">
        <div class="form-group">
          <input name="correo" type="email" class="form-control" placeholder="Correo Electrónico" required />
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


  <!-- Agrega los scripts de Bootstrap y jQuery (si es necesario) -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>

<?php
$loginSuccess = false; // Variable para verificar si el inicio de sesión fue exitoso

// Verificar si se enviaron datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $correo = $_POST["correo"];
  $contrasena = $_POST["contrasena"];

  $host = "localhost";
  $port = 3306;
  $socket = "";
  $user = "root";
  $password = "root";
  $dbname = "pet_shop";

  $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die('Could not connect to the database server' . mysqli_connect_error());

  // Consulta SQL para verificar si el usuario existe en la base de datos
  $query = "SELECT * FROM usuarios WHERE correo = '$correo' AND contrasena = '$contrasena'";
  $result = $con->query($query);

  if ($result->num_rows == 1) {
    // El usuario ha iniciado sesión con éxito
    $loginSuccess = true;
  }

  // Cerrar la conexión a la base de datos
  $con->close();
}
?>

<!-- JavaScript para mostrar el modal solo después de enviar el formulario -->
<script>
  $(document).ready(function() {
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