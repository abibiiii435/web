<?php
session_start();

// Filtro por tipo de producto desde URL
$filtroTipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

// Productos ejemplo (completa con los tuyos)
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
  // Redirige a la misma página para actualizar estado
  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Descuentos | Cristak¿l Grace </title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/login-tab.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="d-flex flex-column min-vh-100">

<!-- NAVBAR -->
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

<!-- Productos con descuento -->
<section class="container py-4">
  <h3 class="mb-4 text-center">Productos en Descuento</h3>
  <div class="row g-4">
    <?php
    // Productos con descuento que me diste antes
    $productosDescuento = [
      ['nombre'=>'Collar de Zafiro','precio_original'=>2000,'precio_descuento'=>1500,'imagen'=>'img/zafiro.png','tipo'=>'cadena'],
      ['nombre'=>'Pulsera con Diamantes','precio_original'=>2500,'precio_descuento'=>1750,'imagen'=>'img/diamante.jpg','tipo'=>'pulsera'],
      ['nombre'=>'Aretes de Topacio','precio_original'=>1000,'precio_descuento'=>800,'imagen'=>'img/topacio.jpg','tipo'=>'arito'],
    ];

    foreach ($productosDescuento as $producto):
    ?>
    <div class="col-md-4">
      <div class="producto-card">
        <div class="producto-img-container">
          <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" />
        </div>
        <div>
          <h5 class="nombre-producto"><?= htmlspecialchars($producto['nombre']) ?></h5>
          <p>
            <span style="text-decoration: line-through; color: #bfa76a;">L.<?= number_format($producto['precio_original'], 2) ?></span>
            <span style="color: #3a6d2c; font-weight: bold; margin-left: 10px;">L.<?= number_format($producto['precio_descuento'], 2) ?></span>
          </p>

          <?php if (!isset($_SESSION['usuario'])): ?>
           <button class="btn-agregar" onclick="return manejarAgregarCarritoSinLogin(event)">Agregar al carrito</button>
          <?php else: ?>
            <form action="agregar_carrito.php" method="post" class="m-0 p-0">
              <input type="hidden" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>">
              <input type="hidden" name="precio" value="<?= $producto['precio_descuento'] ?>">
              <input type="hidden" name="imagen" value="<?= $producto['imagen'] ?>">
             <button type="submit" class="btn-agregar">Agregar al carrito</button>
            </form>
          <?php endif; ?>

        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- Footer -->
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
