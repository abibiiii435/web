<?php
session_start();

$usuarios = [
  'cliente' => 'joyeria456',
  'admin' => 'admin123'
];

$error = '';
$loginExitoso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_login'])) {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';
    if (isset($usuarios[$user]) && $usuarios[$user] === $pass) {
        $_SESSION['usuario'] = $user;
        $loginExitoso = true;
    } else {
        $error = 'Usuario o contraseña incorrectos.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<title>Página con login lateral y mensaje</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="css/login-tab.css" />
<style>
#loginTab {
  position: fixed;
  top: 0; right: -320px;
  width: 320px; height: 100%;
  background: white;
  box-shadow: -2px 0 5px rgba(0,0,0,0.3);
  transition: right 0.3s ease;
  z-index: 1050;
  padding: 20px;
  overflow-y: auto;
}
#loginTab.active {
  right: 0;
}
#loginTabOverlay {
  display: none;
  position: fixed;
  top:0; left:0; width: 100%; height: 100%;
  background: rgba(0,0,0,0.4);
  z-index: 1040;
}
#loginTabOverlay.active {
  display: block;
}
.cerrarBtn {
  background: none;
  border: none;
  font-size: 2rem;
  position: absolute;
  top: 10px; right: 15px;
  cursor: pointer;
}
</style>
</head>
<body>

<!-- Aquí va tu contenido normal -->

<div id="loginTabOverlay" onclick="cerrarLoginTab()"></div>

<div id="loginTab" aria-label="Login">
  <button class="cerrarBtn" aria-label="Cerrar login" onclick="cerrarLoginTab()">&times;</button>
  <h4 class="mb-3">Iniciar Sesión</h4>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" onsubmit="return validarFormulario()">
    <input type="hidden" name="form_login" value="1" />
    <div class="mb-3">
      <label for="username" class="form-label">Usuario</label>
      <input type="text" id="username" name="username" class="form-control" required autofocus />
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Contraseña</label>
      <input type="password" id="password" name="password" class="form-control" required />
    </div>
    <button type="submit" class="btn btn-primary w-100">Entrar</button>
  </form>
</div>

<?php if ($loginExitoso): ?>
<script>
  // Después de iniciar sesión correctamente, redirige a carrito.php
  window.location.href = 'carrito.php';
</script>
<?php endif; ?>

<script>
const usuarioLogueado = <?= isset($_SESSION['usuario']) ? 'true' : 'false' ?>;

// Función que llamas cuando el usuario quiere agregar al carrito
function pedirLoginParaAgregarCarrito() {
  if (!usuarioLogueado) {
    const quiereLogin = confirm('Debes iniciar sesión para agregar al carrito. ¿Quieres iniciar sesión ahora?');
    if (quiereLogin) {
      abrirLoginTab();
    }
    return false; // cancelar acción agregar carrito si no logueado
  }
  return true; // usuario logueado, sigue con agregar al carrito
}

function abrirLoginTab() {
  document.getElementById('loginTab').classList.add('active');
  document.getElementById('loginTabOverlay').classList.add('active');
}

function cerrarLoginTab() {
  document.getElementById('loginTab').classList.remove('active');
  document.getElementById('loginTabOverlay').classList.remove('active');
}

function validarFormulario() {
  const user = document.getElementById('username').value.trim();
  const pass = document.getElementById('password').value.trim();
  if (!user || !pass) {
    alert('Por favor completa ambos campos.');
    return false;
  }
  return true;
}

<?php if ($error): ?>
// Si hay error, abre el login para que corrijan
window.addEventListener('DOMContentLoaded', abrirLoginTab);
<?php endif; ?>
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
