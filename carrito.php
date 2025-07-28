<?php
session_start();

$carrito = $_SESSION['carrito'] ?? [];
$descuentoPorcentaje = $_SESSION['descuento_ruleta'] ?? 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Carrito | Joyería Visual</title>
  <link rel="stylesheet" href="css/style.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="d-flex flex-column min-vh-100">
  <style>
    .modal-overlay, .modal-confirmacion {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 1050;
    }

    .modal-overlay {
      background: rgba(0,0,0,0.6);
    }

    .modal-confirmacion {
      background: white;
      z-index: 1060;
    }

    .modal-content, .modal-content-confirmacion {
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
      width: 90%;
      max-width: 400px;
      animation: fadeInScale 0.3s ease forwards;
    }

    @keyframes fadeInScale {
      0% { opacity: 0; transform: scale(0.9); }
      100% { opacity: 1; transform: scale(1); }
    }

    .modal-content input,
    .modal-content textarea,
    .modal-content select {
      border: 2px solid #b76e79;
      border-radius: 6px;
      padding: 10px;
      font-size: 1rem;
      width: 100%;
      margin-bottom: 15px;
    }

    .modal-content input:focus,
    .modal-content textarea:focus,
    .modal-content select:focus {
      border-color: #f7cac9;
      box-shadow: 0 0 8px #b76e79;
      outline: none;
    }

    #btnComprar {
      background: linear-gradient(45deg, #b76e79, #f7cac9);
      border: none;
      color: white;
      font-weight: bold;
    }

    #btnComprar:hover {
      background: linear-gradient(45deg, #f7cac9, #b76e79);
      box-shadow: 0 0 10px #b76e79;
    }

    .d-none { display: none !important; }

    .titulo-seccion {
      font-weight: 700;
      font-size: 2rem;
      color: #b76e79;
      text-transform: uppercase;
      letter-spacing: 2px;
      margin-bottom: 1rem;
    }
  </style>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" style="min-height: 80px;">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="index.php" style="height: 80%;">
      <img src="img/logo.jpg" alt="Logo" style="height: 100px; object-fit: cover; border-radius: 50%;" />
      <span class="logo-text">Cristal Grace</span>
    </a>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item"><a href="index.php" class="nav-link">Inicio</a></li>
        <li class="nav-item"><a href="productos.php" class="nav-link">Productos</a></li>
        <li class="nav-item"><a href="descuentos.php" class="nav-link">Descuentos</a></li>
        <li class="nav-item"><a href="favoritos.php" class="nav-link">Favoritos</a></li>
        <li class="nav-item"><a href="carrito.php" class="nav-link active">Carrito</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- CARRITO -->
<section class="container py-5">
  <h3 class="titulo-seccion text-center">Mi Carrito</h3>

  <?php if (empty($carrito)): ?>
    <p class="text-center mt-4">No has agregado productos aún.</p>
  <?php else: ?>
    <div class="table-responsive mt-4">
      <table class="table table-bordered text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>Imagen</th>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $total = 0;
          foreach ($carrito as $item):
            $subtotal = $item['precio'] * $item['cantidad'];
            $total += $subtotal;
          ?>
          <tr>
            <td><img src="<?= htmlspecialchars($item['imagen']) ?>" style="width: 80px;" class="img-thumbnail" alt="<?= htmlspecialchars($item['nombre']) ?>"></td>
            <td><?= htmlspecialchars($item['nombre']) ?></td>
            <td>L.<?= number_format($item['precio'], 2) ?></td>
            <td><?= $item['cantidad'] ?></td>
            <td>L.<?= number_format($subtotal, 2) ?></td>
            <td>
              <a href="eliminar_del_carrito.php?nombre=<?= urlencode($item['nombre']) ?>" class="btn btn-danger btn-sm">Eliminar</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="text-end">
      <p><strong>Total sin descuento:</strong> L.<?= number_format($total, 2) ?></p>
      <?php if ($descuentoPorcentaje > 0): 
        $montoDescuento = $total * ($descuentoPorcentaje / 100);
      ?>
        <p class="text-success"><strong>Descuento de ruleta (<?= $descuentoPorcentaje ?>%):</strong> -L.<?= number_format($montoDescuento, 2) ?></p>
        <h5><strong>Total con descuento:</strong> L.<?= number_format($total - $montoDescuento, 2) ?></h5>
      <?php else: ?>
        <h5><strong>Total a pagar:</strong> L.<?= number_format($total, 2) ?></h5>
      <?php endif; ?>

      <button id="btnComprar" class="btn btn-primary btn-lg mt-3">Realizar Compra</button>
    </div>
  <?php endif; ?>
</section>

<!-- MODAL DE PAGO -->
<div id="modalPago" class="modal-overlay d-none">
  <div class="modal-content p-4 rounded shadow-lg">
    <h4 class="mb-4 text-center">Información de Pago</h4>
    <form id="formPago">
      <div class="mb-3">
        <label for="nombreCliente" class="form-label">Nombre completo</label>
        <input type="text" id="nombreCliente" name="nombreCliente" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="direccion" class="form-label">Dirección</label>
        <textarea id="direccion" name="direccion" class="form-control" rows="2" required></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Método de pago</label>
        <select id="metodoPago" name="metodoPago" class="form-select" required>
          <option value="" selected disabled>Selecciona un método</option>
          <option value="tarjeta">Tarjeta de crédito/débito</option>
          <option value="paypal">PayPal</option>
          <option value="efectivo">Efectivo contra entrega</option>
        </select>
      </div>
      <div class="d-flex justify-content-between">
        <button type="button" id="btnCerrarModal" class="btn btn-secondary">Cancelar</button>
        <button type="submit" class="btn btn-success">Finalizar Compra</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL CONFIRMACIÓN -->
<div id="modalConfirmacion" class="modal-confirmacion d-none">
  <div class="modal-content-confirmacion p-4 rounded shadow-lg text-center">
    <h4 class="mb-3 text-success">¡Compra realizada con éxito!</h4>
    <button id="btnVolverInicio" class="btn btn-primary">Volver al inicio</button>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const btnComprar = document.getElementById('btnComprar');
  const modalPago = document.getElementById('modalPago');
  const modalConfirmacion = document.getElementById('modalConfirmacion');
  const btnCerrarModal = document.getElementById('btnCerrarModal');
  const btnVolverInicio = document.getElementById('btnVolverInicio');
  const formPago = document.getElementById('formPago');

  btnComprar?.addEventListener('click', () => {
    modalPago.classList.remove('d-none');
  });

  btnCerrarModal?.addEventListener('click', () => {
    modalPago.classList.add('d-none');
  });

  formPago?.addEventListener('submit', e => {
    e.preventDefault();
    modalPago.classList.add('d-none');
    modalConfirmacion.classList.remove('d-none');
  });

  btnVolverInicio?.addEventListener('click', () => {
    window.location.href = 'index.php';
  });
</script>
</body>
</html>

