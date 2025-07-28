<?php
session_start();

// Filtro por tipo de producto desde URL
$filtroTipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

// Aquí tu array original completo de productos
$productos = [
  ['nombre'=>'Anillo Rosa Rubí','precio'=>1600,'imagen'=>'img/rubi.jpg','tipo'=>'anillo'],
  ['nombre'=>'Aretes de Cristal','precio'=>1100,'imagen'=>'img/cristal.jpg','tipo'=>'arito'],
  ['nombre'=>'Pulsera Dorada','precio'=>900,'imagen'=>'img/dorada.jpg','tipo'=>'pulsera'],
];

// Filtrar productos según tipo
$productosFiltrados = [];
if ($filtroTipo) {
  foreach ($productos as $p) {
    if ($p['tipo'] === $filtroTipo) {
      $productosFiltrados[] = $p;
    }
  }
} else {
  $productosFiltrados = $productos;
}

// Login integrado
$usuarios = [
  'cliente' => 'joyeria456',
  'admin' => 'admin123'
];

$errorLogin = '';
$loginExitoso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_login'])) {
  $user = $_POST['username'] ?? '';
  $pass = $_POST['password'] ?? '';

  if (isset($usuarios[$user]) && $usuarios[$user] === $pass) {
    $_SESSION['usuario'] = $user;
    $loginExitoso = true;
  } else {
    $errorLogin = 'Usuario o contraseña incorrectos.';
  }
}

if ($loginExitoso) {
  header('Location: carrito.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
   <title>Inicio | Cristal Grace </title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/login-tab.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<style>
  .btn-outline-gold {
  color: #bfa243 !important;
  border-color: #bfa243 !important;
  padding: 0.75rem 2.5rem !important;
  font-size: 1.25rem !important;
  border-radius: 0.5rem !important;
  transition: background-color 0.3s, color 0.3s;
}

.btn-outline-gold:hover,
.btn-outline-gold:focus {
  background-color: #bfa243 !important;
  color: white !important;
  border-color: #bfa243 !important;
}

</style>
<body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" style="min-height: 80px;">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="index.php" style="height: 80%;">
      <img src="img/logo.jpg" alt="Logo" style="height: 100px; object-fit: cover; border-radius: 50%;" />
      <span class="logo-text">Cristal Grace</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegación">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav me-3">
        <li class="nav-item"><a href="index.php" class="nav-link active" aria-current="page">Inicio</a></li>
        <li class="nav-item"><a href="productos.php" class="nav-link">Productos</a></li>
        <li class="nav-item"><a href="descuentos.php" class="nav-link">Descuentos</a></li>
        <li class="nav-item"><a href="favoritos.php" class="nav-link">Favoritos</a></li>
        <li class="nav-item"><a href="carrito.php" class="nav-link" onclick="return verificarSesion(event)">Carrito</a></li>
      </ul>

      <form class="d-flex" method="GET" action="buscar.php">
        <select class="form-select me-2" name="q" required>
          <option value="" disabled selected>Buscar por tipo</option>
          <option value="anillo">Anillo</option>
          <option value="pulsera">Pulsera</option>
          <option value="cadena">Cadena</option>
          <option value="arito">Arito</option>
        </select>
        <button class="btn btn-outline-success" type="submit">Buscar</button>
      </form>
    </div>
  </div>
</nav>

<!-- PRIMER BANNER CON CARRUSEL -->
<div class="container py-3">
  <div id="carouselDescuentos1" class="carousel slide mb-5" data-bs-ride="carousel">
    <div class="carousel-inner rounded-3 overflow-hidden">
      <div class="carousel-item active">
        <img src="img/banner.jpg" class="d-block w-100 producto-img" alt="Banner 1" />
      </div>
      <div class="carousel-item">
        <img src="img/banner2.jpg" class="d-block w-100 producto-img" alt="Banner 2" />
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselDescuentos1" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselDescuentos1" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</div>

<!-- Productos favoritos -->
<section class="container py-4">
  <h3 class="mb-4 text-center">Productos Favoritos</h3>
  <div class="row g-4">
    <?php
    $favoritos = [
      ['nombre'=>'Anillo Rosa Rubí','precio'=>1600,'imagen'=>'img/rubi.jpg','tipo'=>'anillo'],
      ['nombre'=>'Aretes de Cristal','precio'=>1100,'imagen'=>'img/cristal.jpg','tipo'=>'arito'],
      ['nombre'=>'Pulsera Dorada','precio'=>900,'imagen'=>'img/dorada.jpg','tipo'=>'pulsera'],
    ];
    foreach ($favoritos as $producto):
    ?>
    <div class="col-md-4">
      <div class="producto-card">
        <div class="producto-img-container">
          <img src="<?= $producto['imagen'] ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" />
        </div>
        <div>
          <h5 class="nombre-producto"><?= htmlspecialchars($producto['nombre']) ?></h5>
          <p class="precio-nuevo">L.<?= number_format($producto['precio'], 2) ?></p>

          <?php if (!isset($_SESSION['usuario'])): ?>
            <button class="btn-agregar" onclick="return verificarSesion(event)">Agregar al carrito</button>
          <?php else: ?>
            <form action="agregar_carrito.php" method="post">
              <input type="hidden" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>">
              <input type="hidden" name="precio" value="<?= $producto['precio'] ?>">
              <input type="hidden" name="imagen" value="<?= $producto['imagen'] ?>">
              <button type="submit" class="btn-agregar">Agregar al carrito</button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <br>
 <section class="banner-principal d-flex align-items-center justify-content-center text-center text-white" style="height: 100px;">
  <div>
    <a href="favoritos.php" id="btnVerMasFavoritos" class="btn btn-outline-gold btn-lg mt-3">Ver más favoritos</a>
  </div>
</section>


<!-- SEGUNDO BANNER CON CARRUSEL -->
<div class="container py-3">
  <div id="carouselDescuentos2" class="carousel slide mb-5" data-bs-ride="carousel">
    <div class="carousel-inner rounded-3 overflow-hidden">
      <div class="carousel-item active">
        <img src="img/banner3.png" class="d-block w-100 producto-img" alt="Banner 3" />
      </div>
      <div class="carousel-item">
        <img src="img/banner4.png" class="d-block w-100 producto-img" alt="Banner 4" />
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselDescuentos2" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselDescuentos2" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</div>

<!-- FOOTER -->
<footer class="footer mt-auto">
  <div class="container text-center py-4">
    <h5>Información de contacto</h5>
    <p>Email: contacto@joyeriavisual.com | Tel: +504 1234-5678</p>
    <p>Dirección: Centro Comercial Las Joyas, Local 12, Tegucigalpa</p>
  </div>
</footer>

<!-- Pestaña de login integrada -->
<div id="loginTab" aria-hidden="true" role="dialog" aria-labelledby="loginTabTitle" tabindex="-1">
  <button class="cerrarBtn" aria-label="Cerrar" onclick="cerrarLoginTab()">&times;</button>
  <div class="logo-container">
    <img src="img/logo.jpg" alt="Logo Cristal Grace" style="height:80px;" />
  </div>
  <h4 id="loginTabTitle">Iniciar Sesión</h4>

  <?php if ($errorLogin): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($errorLogin) ?></div>
  <?php endif; ?>

  <form method="POST" onsubmit="return validarLogin()">
    <input type="hidden" name="form_login" value="1" />
    <div class="mb-3">
      <label for="loginUsername" class="form-label">Usuario</label>
      <input type="text" id="loginUsername" name="username" class="form-control" required autofocus />
    </div>
    <div class="mb-3">
      <label for="loginPassword" class="form-label">Contraseña</label>
      <input type="password" id="loginPassword" name="password" class="form-control" required />
    </div>
    <button type="submit" class="btn btn-primary w-100">Entrar</button>
  </form>
</div>
<div id="loginTabOverlay" onclick="cerrarLoginTab()" tabindex="-1" aria-hidden="true"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  function verificarSesion(e) {
    <?php if (!isset($_SESSION['usuario'])): ?>
      e.preventDefault();
      if (confirm('Debes iniciar sesión para acceder. ¿Quieres iniciar sesión ahora?')) {
        abrirLoginTab();
      }
      return false;
    <?php else: ?>
      return true;
    <?php endif; ?>
  }

function abrirLoginTab() {
  document.getElementById('loginTab').classList.add('active');
  document.getElementById('loginTab').setAttribute('aria-hidden', 'false');
  document.getElementById('loginTabOverlay').classList.add('active');
  document.body.classList.add('login-active');  // <- Añadido para desenfoque
  document.getElementById('loginUsername').focus();
}

function cerrarLoginTab() {
  document.getElementById('loginTab').classList.remove('active');
  document.getElementById('loginTab').setAttribute('aria-hidden', 'true');
  document.getElementById('loginTabOverlay').classList.remove('active');
  document.body.classList.remove('login-active');  // <- Remueve desenfoque
}


  function validarLogin() {
    const user = document.getElementById('loginUsername').value.trim();
    const pass = document.getElementById('loginPassword').value.trim();
    if (!user || !pass) {
      alert('Por favor, completa usuario y contraseña.');
      return false;
    }
    return true;
  }

  <?php if ($errorLogin): ?>
    document.addEventListener('DOMContentLoaded', () => {
      abrirLoginTab();
    });
  <?php endif; ?>
</script>

</body>
</html>
