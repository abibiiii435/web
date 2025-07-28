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

// Usuarios válidos
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
  // Redirige a la misma página para refrescar estado logueado (puedes cambiar a otra)
  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}



$productos = [
  [
    'nombre' => 'Aretes de Topacio',
    'precio' => 800,
    'imagen' => 'img/topacio1.jpg',
    'tipo' => 'arito',
    'descripcion' => 'Aretes delicados con topacio natural que resaltan tu elegancia en cualquier ocasión.',
    'material' => 'Plata de ley 925 con incrustaciones de topacio auténtico.',
    'calidad' => 'Hechos a mano, libres de níquel y resistentes al agua.',
    'imagenes_ref' => ['img/topacio1.jpg', 'img/topacio2.jpg', 'img/topacio3.jpg']
  ],
  [
    'nombre' => 'Arito de Flor Rosa',
    'precio' => 850,
    'imagen' => 'img/Aretes de flor rosa.jpg',
    'tipo' => 'arito',
    'descripcion' => 'Arito con diseño de flor rosa, delicado y femenino, perfecto para uso diario.',
    'material' => 'Aleación hipoalergénica con baño de oro rosa.',
    'calidad' => 'Durabilidad garantizada y acabado suave.',
    'imagenes_ref' => ['img/Aretes de flor rosa.jpg', 'img/Aretes de flor rosa1.jpg', 'img/Aretes de flor rosa2.jpg']
  ],
  [
    'nombre' => 'Collar de Zafiro',
    'precio' => 1500,
    'imagen' => 'img/zafiro.png',
    'tipo' => 'cadena',
    'descripcion' => 'Hermoso collar de zafiro azul, ideal para ocasiones elegantes y formales.',
    'material' => 'Cadena de plata 925 con colgante de zafiro natural.',
    'calidad' => 'Acabado premium, resistente y brillante.',
    'imagenes_ref' => ['img/zafiro.png', 'img/zafiro2.jpg', 'img/zafiro3.jpg']
  ],
  [
    'nombre' => 'Collar de Margarita Plata de Ley 925',
    'precio' => 1300,
    'imagen' => 'img/Collar de margarita plata de ley 925.jpg',
    'tipo' => 'cadena',
    'descripcion' => 'Collar en forma de margarita hecho en plata de ley 925, símbolo de pureza y belleza natural.',
    'material' => 'Plata de ley 925 con acabado pulido.',
    'calidad' => 'Alta resistencia al desgaste y brillo duradero.',
    'imagenes_ref' => ['img/Collar de margarita plata de ley 925.jpg', 'img/Collar de margarita plata de ley 925 1.jpg', 'img/Collar de margarita plata de ley 925 2.jpg']
  ],
  [
    'nombre' => 'Pulsera con Diamantes',
    'precio' => 1750,
    'imagen' => 'img/diamante.jpg',
    'tipo' => 'pulsera',
    'descripcion' => 'Pulsera brillante con diamantes incrustados que aportan elegancia y sofisticación.',
    'material' => 'Oro blanco con diamantes certificados.',
    'calidad' => 'Artesanía fina con piedras de calidad premium.',
    'imagenes_ref' => ['img/diamante.jpg', 'img/diamante2.jpg', 'img/diamante3.jpg']
  ],
  [
    'nombre' => 'Pulsera de Eslabones de Oro',
    'precio' => 2100,
    'imagen' => 'img/eslabones.jpg',
    'tipo' => 'pulsera',
    'descripcion' => 'Pulsera con eslabones gruesos bañada en oro brillante, un clásico atemporal.',
    'material' => 'Base de acero inoxidable con baño de oro 18k.',
    'calidad' => 'Resistente a arañazos y con acabado brillante.',
    'imagenes_ref' => ['img/eslabones.jpg', 'img/eslabones1.jpg']
  ],
  [
    'nombre' => 'Anillo de Esmeralda',
    'precio' => 1950,
    'imagen' => 'img/esmeralda.jpg',
    'tipo' => 'anillo',
    'descripcion' => 'Anillo elegante con esmeralda verde montada en oro, símbolo de renovación y amor.',
    'material' => 'Oro amarillo de 14k con esmeralda natural.',
    'calidad' => 'Piedra cuidadosamente tallada y montada a mano.',
    'imagenes_ref' => ['img/esmeralda.jpg', 'img/esmeralda2.jpg']
  ],
  [
    'nombre' => 'Anillo de Oro Rosa',
    'precio' => 1700,
    'imagen' => 'img/oro rosa.jpg',
    'tipo' => 'anillo',
    'descripcion' => 'Anillo delicado de oro rosa, con estilo minimalista para quienes aman lo sutil.',
    'material' => 'Oro rosa de 14 quilates con acabado mate.',
    'calidad' => 'Diseño ligero y cómodo para uso diario.',
    'imagenes_ref' => ['img/oro rosa.jpg', 'img/oro rosa1.jpg', 'img/oro rosa 2.jpg']
  ],
  [
    'nombre' => 'Anillo Rosa Rubí',
    'precio' => 1600,
    'imagen' => 'img/rubi.jpg',
    'tipo' => 'anillo',
    'descripcion' => 'Anillo dorado con rubí rosa brillante que simboliza pasión y romanticismo.',
    'material' => 'Oro amarillo con rubí sintético de alta calidad.',
    'calidad' => 'Durabilidad excepcional y diseño llamativo.',
    'imagenes_ref' => ['img/rubi.jpg', 'img/rubi1.jpg']
  ],
  [
    'nombre' => 'Arito de Perlas',
    'precio' => 950,
    'imagen' => 'img/perlas.jpg',
    'tipo' => 'arito',
    'descripcion' => 'Aretes clásicos con perlas blancas naturales, perfectos para un look elegante y atemporal.',
    'material' => 'Plata de ley con perlas cultivadas naturales.',
    'calidad' => 'Acabado fino y resistencia al desgaste.',
    'imagenes_ref' => ['img/perlas.jpg', 'img/perlas1.jpg', 'img/perlas2.jpg']
  ],
  [
    'nombre' => 'Pulsera Dorada',
    'precio' => 900,
    'imagen' => 'img/dorada.jpg',
    'tipo' => 'pulsera',
    'descripcion' => 'Pulsera dorada minimalista ideal para complementar tu estilo diario con brillo sutil.',
    'material' => 'Aleación con baño de oro amarillo 14k.',
    'calidad' => 'Ligera y resistente al uso cotidiano.',
    'imagenes_ref' => ['img/dorada.jpg', 'img/dorada2.jpg', 'img/dorada3.jpg']
  ],
  [
    'nombre' => 'Pulsera Tenis Chapada en Oro 14k',
    'precio' => 2500,
    'imagen' => 'img/pulsera de tenis chapada en oro de 14 quilates 1.jpg',
    'tipo' => 'pulsera',
    'descripcion' => 'Pulsera tipo tenis chapada en oro de 14 quilates, perfecta para ocasiones especiales.',
    'material' => 'Cadena de plata chapada en oro 14k con circonias.',
    'calidad' => 'Diseño elegante con piedras brillantes.',
    'imagenes_ref' => ['img/pulsera de tenis chapada en oro de 14 quilates 1.jpg', 'img/pulsera de tenis chapada en oro de 14 quilates 2.jpg']
  ],
  [
    'nombre' => 'Pulsera Oro de 18 Quilates',
    'precio' => 3200,
    'imagen' => 'img/Pulsera oro de 18 quilates.jpg',
    'tipo' => 'pulsera',
    'descripcion' => 'Pulsera exclusiva de oro macizo de 18 quilates, símbolo de lujo y distinción.',
    'material' => 'Oro macizo 18k con diseño exclusivo.',
    'calidad' => 'Acabado artesanal y durabilidad extrema.',
    'imagenes_ref' => ['img/Pulsera oro de 18 quilates.jpg', 'img/Pulsera oro de 18 quilates 1.jpg', 'img/Pulsera oro de 18 quilates 2.jpg']
  ],
  [
    'nombre' => 'Aretes de Cristal',
    'precio' => 1100,
    'imagen' => 'img/cristal.jpg',
    'tipo' => 'arito',
    'descripcion' => 'Aretes brillantes con cristales tallados a mano, para un toque de glamour único.',
    'material' => 'Aleación metálica con cristales Swarovski.',
    'calidad' => 'Corte preciso y alta reflectividad.',
    'imagenes_ref' => ['img/cristal.jpg', 'img/cristal2.jpg', 'img/cristal3.jpg']
  ],
  [
    'nombre' => 'Anillo de Corazon',
    'precio' => 2200,
    'imagen' => 'img/Anillo de compromiso de plata de ley 925.jpg',
    'tipo' => 'anillo',
    'descripcion' => 'Anillo elegante con rubí rojo brillante, símbolo de amor y compromiso eterno.',
    'material' => 'Plata de ley 925 con baño de rodio y rubí natural.',
    'calidad' => 'Diseño fino, resistente y cómodo para uso diario.',
    'imagenes_ref' => ['img/Anillo de compromiso de plata de ley 925.jpg', 'img/Anillo de compromiso de plata de ley 925 1.jpg', 'img/Anillo de compromiso de plata de ley 925 2.jpg']
  ]
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
   <title>Productos | Cristak¿l Grace </title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/login-tab.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<style>
  .producto-oculto {
      display: none;
    }

    /* Estilos para el botón dorado grande */
    #btnVerMas.btn-outline-gold {
      color: #bfa243 !important;
      border-color: #bfa243 !important;
      padding: 0.75rem 2.5rem !important;
      font-size: 1.25rem !important;
      border-radius: 0.5rem !important;
      transition: background-color 0.3s, color 0.3s;
    }

    #btnVerMas.btn-outline-gold:hover,
    #btnVerMas.btn-outline-gold:focus {
      background-color: #bfa243 !important;
      color: white !important;
      border-color: #bfa243 !important;
    }
</style>

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

<!-- PRODUCTOS -->
<div class="container py-5">
  <div class="row" id="productos-container">
    <?php foreach ($productos as $index => $producto): ?>
      <div class="col-md-4 mb-4 <?= $index >= 6 ? 'producto-oculto' : '' ?>">
        <div class="producto-card">
          <div class="producto-img-container">
            <!-- Imagen que abre modal -->
            <img src="<?= htmlspecialchars($producto['imagen']) ?>" 
                 alt="<?= htmlspecialchars($producto['nombre']) ?>" 
                 class="img-principal" 
                 data-bs-toggle="modal" 
                 data-bs-target="#productoModal<?= $index ?>">
          </div>
          <h5 class="nombre-producto mt-3 text-center"><?= htmlspecialchars($producto['nombre']) ?></h5>
          <span class="precio-nuevo d-block text-center">L.<?= number_format($producto['precio'], 2) ?></span>
          <form action="agregar_carrito.php" method="POST" onsubmit="return verificarSesionAgregar(event)">
            <input type="hidden" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>">
            <input type="hidden" name="precio" value="<?= $producto['precio'] ?>">
            <input type="hidden" name="imagen" value="<?= htmlspecialchars($producto['imagen']) ?>">
            <button type="submit" class="btn-agregar mt-2 w-100">Agregar al carrito</button>
          </form>
        </div>
      </div>

      <!-- MODAL DEL PRODUCTO -->
      <div class="modal fade" id="productoModal<?= $index ?>" tabindex="-1" aria-labelledby="productoModalLabel<?= $index ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="productoModalLabel<?= $index ?>"><?= htmlspecialchars($producto['nombre']) ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div id="carousel<?= $index ?>" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                      <?php foreach ($producto['imagenes_ref'] as $i => $img): ?>
                        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                          <img src="<?= htmlspecialchars($img) ?>" class="d-block w-100" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                        </div>
                      <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?= $index ?>" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel<?= $index ?>" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Siguiente</span>
                    </button>
                  </div>
                </div>
                <div class="col-md-6">
                  <p><strong>Descripción:</strong> <?= htmlspecialchars($producto['descripcion']) ?></p>
                  <p><strong>Material:</strong> <?= htmlspecialchars($producto['material']) ?></p>
                  <p><strong>Calidad:</strong> <?= htmlspecialchars($producto['calidad']) ?></p>
                  <p class="fw-bold fs-4">L.<?= number_format($producto['precio'], 2) ?></p>
                  <form action="agregar_carrito.php" method="POST" onsubmit="return verificarSesionAgregar(event)">
                    <input type="hidden" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>">
                    <input type="hidden" name="precio" value="<?= $producto['precio'] ?>">
                    <input type="hidden" name="imagen" value="<?= htmlspecialchars($producto['imagen']) ?>">
                    <button type="submit" class="btn-agregar mt-2 w-100">Agregar al carrito</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="text-center mt-4">
   <button id="btnVerMas" class="btn btn-outline-gold">Ver más productos</button>

  </div>
</div>

<!-- PESTAÑA LATERAL LOGIN -->
<div id="loginTab" aria-hidden="true" role="dialog" aria-labelledby="loginTabTitle" tabindex="-1">
  <button class="cerrarBtn" aria-label="Cerrar" onclick="cerrarLoginTab()">&times;</button>
  <div class="logo-container">
    <img src="img/logo.jpg" alt="Logo Cristal Grace" style="height:80px;" />
  </div>
  <h4 id="loginTabTitle">Iniciar Sesión</h4>
  <?php if ($errorLogin): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($errorLogin) ?></div>
  <?php endif; ?>
  <form method="POST" action="" id="loginForm" novalidate>
    <input type="hidden" name="form_login" value="1" />
    <div class="mb-3">
      <label for="loginUsername" class="form-label">Usuario</label>
      <input type="text" class="form-control" id="loginUsername" name="username" required />
    </div>
    <div class="mb-3">
      <label for="loginPassword" class="form-label">Contraseña</label>
      <input type="password" class="form-control" id="loginPassword" name="password" required />
    </div>
    <button type="submit" class="btn btn-success w-100">Ingresar</button>
  </form>
</div>
<div id="loginTabOverlay" onclick="cerrarLoginTab()"></div>

<!-- FOOTER -->
<footer class="footer mt-auto">
  <div class="container text-center py-4">
    <h5>Información de contacto</h5>
    <p>Email: contacto@joyeriavisual.com | Tel: +504 1234-5678</p>
    <p>Dirección: Centro Comercial Las Joyas, Local 12, Tegucigalpa</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const usuarioLogueado = <?= isset($_SESSION['usuario']) ? 'true' : 'false' ?>;

  function verificarSesionAgregar(event) {
    if (!usuarioLogueado) {
      event.preventDefault();
      const quiereLogin = confirm('Debes iniciar sesión para agregar al carrito. ¿Quieres iniciar sesión ahora?');
      if (quiereLogin) {
        abrirLoginTab();
      }
      return false;
    }
    return true;
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

  // Confirmar acceso a carrito desde el link del navbar
  function verificarSesion(event) {
    if (!usuarioLogueado) {
      event.preventDefault();
      if (confirm('Debes iniciar sesión para acceder al carrito. ¿Quieres iniciar sesión ahora?')) {
        abrirLoginTab();
      }
      return false;
    }
    return true;
  }

  // Botón Ver Más productos (muestra productos ocultos)
  document.getElementById('btnVerMas').addEventListener('click', () => {
    document.querySelectorAll('.producto-oculto').forEach(el => el.style.display = 'block');
    document.getElementById('btnVerMas').style.display = 'none';
  });
</script>

</body>
</html>