<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PetShop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="styles/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
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
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
            <!-- Verifica si el usuario es administrador antes de mostrar el enlace -->

            <?php // En index.php
            if (isset($_GET["esAdmin"]) && $_GET["esAdmin"] === "true"): ?>
              <li class="nav-item"><a href="ingresarProducto.php" class="nav-link active" aria-current="page">Modo Administrador</a></li>
            <?php endif; ?>
          </ul>



          <a href="login.php"><img class="img-icon img-fluid" src="ico/person-circle.svg" alt="" /></a>

        </div>
      </div>
    </nav>
  </div>
  <!-- Seccion fotos mascotas  -->
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <img src="img/imglarge.jpg" alt="Imagen 1" class="img-fluid" style="height: 875px" />
      </div>

      <div class="col-md-6">
        <img src="img/img1.jpg" alt="Imagen 2" class="img-fluid" />
        <br /><br />

        <img src="img/img2.jpg" alt="Imagen 3" class="img-fluid" />
      </div>
    </div>
  </div>
  <br /><br />
  <!-- Seccion Productos recomendados -->
  <h4 class="text-center">Recomendados</h4>
  <hr class="hr-center" />
  <br />
  <div class="container text-center container-products">
    <div class="row">
      <div class="col">
        <div class="card">
          <img src="img/products/comida.png" class="card-img-top" alt="..." />
          <div class="card-body">
            <h5 class="card-title">Cat Chow</h5>

            <a href="productos.php" class="btn btn-primary">Ir a la tienda</a>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <img src="img/products/6501263b81c5c_alimento-seco.png" class="card-img-top" alt="..." />
          <div class="card-body">
            <h5 class="card-title">Procan para Cachorro</h5>
            <a href="productos.php" class="btn btn-primary">Ir la tienda</a>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <img src="img/products/6501de81efe80_pngegg.png" class="card-img-top" alt="..." />
          <div class="card-body">
            <h5 class="card-title">Whiskas</h5>
            <a href="productos.php" class="btn btn-primary">Ir a la tienda</a>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <img src="img/products/65012a505d944_Adultos-original-pollo-PRONACA2.png" class="card-img-top" alt="..." />
          <div class="card-body">
            <h5 class="card-title">Pro Can para Adultos</h5>
            <a href="productos.php" class="btn btn-primary">Ir a la tienda</a>
          </div>
        </div>
      </div>
    </div>
    <br />
  </div>
  <br /><br />
  <!--Seccion Elije Mascota  -->
  <div id="container-head1">
    <h3 class="text-center">Compra Por Mascota</h3>
  </div>
<div class="container mt-4">
  <div class="row container-categories">
    <div class="col-md-3 mb-3">
      <div class="text-center image-container">
        <a href="productos.php?tipomascota=gato" class="d-block no-link-style">
          <img src="img/categories/gato.jpg" alt="Imagen 1" class="rounded-circle img-thumbnail circle-pets" />
          <div class="mt-2">
            <p>Gatos</p>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="text-center image-container">
        <a href="productos.php?tipomascota=perro" class="d-block no-link-style">
          <img src="img/categories/perro.jpg" alt="Imagen 2" class="rounded-circle img-thumbnail circle-pets" />
          <div class="mt-2">
            <p>Perros</p>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="text-center image-container">
        <a href="productos.php?tipomascota=pez" class="d-block no-link-style">
          <img src="img/categories/pez.jpg" alt="Imagen 3" class="rounded-circle img-thumbnail circle-pets" />
          <div class="mt-2">
            <p>Peces</p>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="text-center image-container">
        <a href="productos.php?tipomascota=otros" class="d-block no-link-style">
          <img src="img/categories/otros.jpg" alt="Imagen 3" class="rounded-circle img-thumbnail circle-pets" />
          <div class="mt-2">
            <p>Otros</p>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>

  <!-- Seccion servicios -->
  <div class="container mt-5 container-servicios">
    <div class="row justify-content-center">
      <div class="col-md-3 container-service">
        <div class="image-container text-center">
          <svg xmlns="http://www.w3.org/2000/svg" fill="rgb(81, 117, 99)" class="bi bi-award" viewBox="0 0 16 16">
            <path
              d="M9.669.864 8 0 6.331.864l-1.858.282-.842 1.68-1.337 1.32L2.6 6l-.306 1.854 1.337 1.32.842 1.68 1.858.282L8 12l1.669-.864 1.858-.282.842-1.68 1.337-1.32L13.4 6l.306-1.854-1.337-1.32-.842-1.68L9.669.864zm1.196 1.193.684 1.365 1.086 1.072L12.387 6l.248 1.506-1.086 1.072-.684 1.365-1.51.229L8 10.874l-1.355-.702-1.51-.229-.684-1.365-1.086-1.072L3.614 6l-.25-1.506 1.087-1.072.684-1.365 1.51-.229L8 1.126l1.356.702 1.509.229z" />
            <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z" />
          </svg>
          <h4>Servicio Premium</h4>
        </div>
      </div>
      <div class="col-md-3 container-service">
        <div class="image-container text-center">
          <svg xmlns="http://www.w3.org/2000/svg" fill="rgb(81, 117, 99)" class="bi bi-hourglass-split"
            viewBox="0 0 16 16">
            <path
              d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z" />
          </svg>
          <h4>
            Envíos <br />
            Rápidos
          </h4>
        </div>
      </div>
      <div class="col-md-3 container-service">
        <div class="image-container text-center">
          <svg xmlns="http://www.w3.org/2000/svg" fill="rgb(81, 117, 99)" class="bi bi-percent" viewBox="0 0 16 16">
            <path
              d="M13.442 2.558a.625.625 0 0 1 0 .884l-10 10a.625.625 0 1 1-.884-.884l10-10a.625.625 0 0 1 .884 0zM4.5 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm7 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
          </svg>
          <h4>Descuentos Especiales</h4>
        </div>
      </div>
    </div>
  </div>
  <!-- Seccion Marcas -->
  <div id="container-head1" class="mb-lg-5">
    <h3 class="text-center">Nuestras Marcas</h3>
  </div>
  <div id="container-brands">
    <div class="row mt-5">
      <div class="col"></div>
      <div class="col">
        <img src="img/brands/pro-can@2x.png" alt="" />
      </div>
      <div class="col"><img src="img/brands/dog chow.png" alt="" /></div>
      <div class="col">
        <img src="img/brands/pedigree_logo_blue.png" alt="" />
      </div>
      <div class="col"></div>
    </div>
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-3">
        <img src="img/brands/catchow-removebg-preview.png " alt="" />
      </div>
      <div class="col-md-3"><img src="img/brands/whiskas.png" alt="" /></div>
    </div>
  </div>
  <br /><br />
  <!-- Seccion Sobre Nosotros -->
  <div class="row">
    <div class="col-12 text-center text-break" id="container-about-us">
      <h2>¿Quienes somos?</h2>
      <p>
        En PetStore, somos amantes de las mascotas que entienden que tu amigo
        peludo es parte de tu familia.
        <br />
        Esperamos ser tu compañero de confianza en el viaje de cuidar, mimar y
        compartir la vida con tus adorables compañeros. <br />
        Nuestra misión es proporcionar productos y servicios de alta calidad
        que fomenten la salud, la felicidad y la vitalidad de tus compañeros
        peludos. <br />
        Creemos en la importancia de crear vínculos duraderos y ofrecer un
        servicio excepcional a nuestros clientes y sus queridas mascotas.
        <br /><br />
        ¡Te damos la bienvenida a PetStore, donde el amor por las mascotas es
        nuestra razón de ser!
      </p>
    </div>
  </div>
  <!-- Seccion Caja de comentarios -->
  <div class="container container-comments mt-5">
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

  <div class="row text-center container-contact">
    <div class="col-md-4">
      <span><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
          <path
            d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
        </svg>
        0987493979</span>
    </div>
    <div class="col-md-4">
      <span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
          <path
            d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
        </svg>
        alcidessainz99@gmail.com
      </span>
    </div>
    <div class="col-md-4">
      <a href="" class="no-link-style">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-github"
          viewBox="0 0 16 16">
          <path
            d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z" />
        </svg></a>
      <a href="" class="no-link-style">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram"
          viewBox="0 0 16 16">
          <path
            d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
        </svg></a>
      <a href="" class="no-link-style">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp"
          viewBox="0 0 16 16">
          <path
            d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
        </svg></a>
      <a href="" class="no-link-style">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook"
          viewBox="0 0 16 16">
          <path
            d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
        </svg></a>
      <a href="" class="no-link-style">
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
  <script src="script.js"></script>
</body>

</html>