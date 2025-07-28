<?php
session_start();

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
  // Redirigir a la misma página para refrescar estado (o cambia a carrito.php si prefieres)
  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}

// Recoger filtro de tipo desde URL
$filtroTipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

// Array original de productos (ejemplo)
$productos = [
  // Aquí va tu array original si usas filtrado o más productos
];

// Filtrar productos según tipo seleccionado
$productosFiltrados = [];

if ($filtroTipo) {
  foreach ($productos as $producto) {
    if ($producto['tipo'] === $filtroTipo) {
      $productosFiltrados[] = $producto;
    }
  }
} else {
  $productosFiltrados = $productos;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Favoritos | Cristak¿l Grace </title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/login-tab.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
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

<!-- BANNER DE IMAGEN -->
<section class="banner-img">
  <img src="img/banner boda.png" alt="Banner Joyería Visual" class="img-fluid w-100" />
</section>

<section class="container py-5">
  <h2 class="titulo-seccion text-center mb-4">Favoritos del Mes</h2>
  <div class="row">
    <?php
    $favoritos = [
      ['nombre' => 'Anillo de Compromiso Oro Blanco', 'precio' => 2500, 'imagen' => 'img/anillo1.jpg', 'tipo' => 'anillo'],
      ['nombre' => 'Anillo de Promesa con Corazón de Plata', 'precio' => 1200, 'imagen' => 'img/anillo22.jpg', 'tipo' => 'anillo'],
      ['nombre' => 'Anillo de Compromiso con Diamante', 'precio' => 3000, 'imagen' => 'img/anillo3.jpg', 'tipo' => 'anillo'],
      ['nombre' => 'Anillo de Promesa Minimalista Oro Rosa', 'precio' => 1100, 'imagen' => 'img/anillo4.jpg', 'tipo' => 'anillo'],
      ['nombre' => 'Anillo de Compromiso Halo de Platino', 'precio' => 3500, 'imagen' => 'img/anillo5.jpg', 'tipo' => 'anillo'],
      ['nombre' => 'Anillo de Promesa con Piedra Azul', 'precio' => 1300, 'imagen' => 'img/anillo6.jpg', 'tipo' => 'anillo'],
      ['nombre' => 'Anillo de Compromiso Oro Amarillo', 'precio' => 2800, 'imagen' => 'img/anillo7.jpg', 'tipo' => 'anillo'],
      ['nombre' => 'Anillo de Promesa Trenzado Plata', 'precio' => 1000, 'imagen' => 'img/anillo8.jpg', 'tipo' => 'anillo'],
      ['nombre' => 'Anillo de Compromiso con Esmeralda', 'precio' => 3200, 'imagen' => 'img/anillo9.jpg', 'tipo' => 'anillo'],
    ];
    foreach ($favoritos as $fav):
    ?>
    <div class="col-md-4 mb-4">
      <div class="producto-card">
        <div class="producto-img-container">
          <img src="<?= htmlspecialchars($fav['imagen']) ?>" alt="<?= htmlspecialchars($fav['nombre']) ?>" class="img-principal" />
        </div>
        <h5 class="nombre-producto mt-2"><?= htmlspecialchars($fav['nombre']) ?></h5>
        <span class="precio-nuevo">L.<?= number_format($fav['precio'], 2) ?></span>
        <?php if (!isset($_SESSION['usuario'])): ?>
          <button class="btn-agregar mt-2 w-100" onclick="return manejarAgregarCarritoSinLogin(event)">Agregar al carrito</button>
        <?php else: ?>
          <form action="agregar_carrito.php" method="POST" class="m-0 p-0" onsubmit="return true;">
            <input type="hidden" name="nombre" value="<?= htmlspecialchars($fav['nombre']) ?>" />
            <input type="hidden" name="precio" value="<?= $fav['precio'] ?>" />
            <input type="hidden" name="imagen" value="<?= htmlspecialchars($fav['imagen']) ?>" />
            <button type="submit" class="btn-agregar mt-2 w-100">Agregar al carrito</button>
          </form>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

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
  const usuarioLogueado = <?= isset($_SESSION['usuario']) ? 'true' : 'false' ?>;

  function verificarSesion(e) {
    if (!usuarioLogueado) {
      e.preventDefault();
      if (confirm('Debes iniciar sesión para acceder. ¿Quieres iniciar sesión ahora?')) {
        abrirLoginTab();
      }
      return false;
    }
    return true;
  }

  function manejarAgregarCarritoSinLogin(e) {
    e.preventDefault();
    if (confirm('Debes iniciar sesión para agregar al carrito. ¿Quieres iniciar sesión ahora?')) {
      abrirLoginTab();
    }
    return false;
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
