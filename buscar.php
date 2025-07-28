<?php
session_start();

// Incluir productos sin mostrar contenido
ob_start(); include 'productos.php'; $productos_todos = $productos; ob_end_clean();
ob_start(); include 'favoritos.php'; $productos_favoritos = $favoritos; ob_end_clean();

$productos_completos = array_merge($productos_todos, $productos_favoritos);

$query = isset($_GET['q']) ? strtolower(trim($_GET['q'])) : '';

$resultados = [];
if ($query !== '') {
  foreach ($productos_completos as $producto) {
    if (strtolower($producto['tipo']) === $query) {
      $resultados[] = $producto;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Buscar por tipo - Joyería Visual</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/login-tab.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

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
          <option value="" disabled <?= $query === '' ? 'selected' : '' ?>>Buscar por tipo</option>
          <option value="anillo" <?= $query === 'anillo' ? 'selected' : '' ?>>Anillo</option>
          <option value="pulsera" <?= $query === 'pulsera' ? 'selected' : '' ?>>Pulsera</option>
          <option value="cadena" <?= $query === 'cadena' ? 'selected' : '' ?>>Cadena</option>
          <option value="arito" <?= $query === 'arito' ? 'selected' : '' ?>>Arito</option>
        </select>
        <button class="btn btn-outline-success" type="submit">Buscar</button>
      </form>
    </div>
  </div>
</nav>

<section class="container py-4">
  <h2 class="mb-4 text-center">Resultados por tipo: <em><?= htmlspecialchars($query) ?></em></h2>

  <?php if ($query === ''): ?>
    <p class="text-center text-muted">Por favor, selecciona un tipo de producto para buscar.</p>
  <?php elseif (empty($resultados)): ?>
    <p class="text-center text-muted">No se encontraron productos del tipo <strong><?= htmlspecialchars($query) ?></strong>.</p>
  <?php else: ?>
    <div class="row g-4">
      <?php foreach ($resultados as $producto): ?>
        <div class="col-md-4">
          <div class="producto-card">
            <div class="producto-img-container">
              <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" />
            </div>
            <div>
              <h5 class="nombre-producto"><?= htmlspecialchars($producto['nombre']) ?></h5>
              <p class="precio-nuevo">L.<?= number_format($producto['precio'], 2) ?></p>

              <?php if (isset($producto['material'])): ?>
                <p class="text-muted small mb-2"><?= htmlspecialchars($producto['material']) ?></p>
              <?php endif; ?>

              <?php if (!isset($_SESSION['usuario'])): ?>
                <button class="btn-agregar" onclick="return verificarSesion(event)">Agregar al carrito</button>
              <?php else: ?>
                <form action="agregar_carrito.php" method="post">
                  <input type="hidden" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>">
                  <input type="hidden" name="precio" value="<?= $producto['precio'] ?>">
                  <input type="hidden" name="imagen" value="<?= htmlspecialchars($producto['imagen']) ?>">
                  <button type="submit" class="btn-agregar">Agregar al carrito</button>
                </form>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>


<!-- Pestaña de login integrada -->
<div id="loginTab" aria-label="Formulario de inicio de sesión" role="dialog" aria-modal="true" aria-hidden="true" tabindex="-1">
  <button class="cerrarBtn" aria-label="Cerrar formulario de inicio de sesión" onclick="cerrarLoginTab()">&times;</button>
  <h4>Iniciar Sesión</h4>

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
    document.getElementById('loginUsername').focus();
  }

  function cerrarLoginTab() {
    document.getElementById('loginTab').classList.remove('active');
    document.getElementById('loginTab').setAttribute('aria-hidden', 'true');
    document.getElementById('loginTabOverlay').classList.remove('active');
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
