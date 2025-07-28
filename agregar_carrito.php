<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
  $_SESSION['mensaje_carrito'] = "Debes iniciar sesión para agregar productos al carrito.";
  header("Location: login.php");
  exit();
}

// Recoger y validar datos del formulario
$nombre = $_POST['nombre'] ?? '';
$precio = isset($_POST['precio']) ? floatval($_POST['precio']) : 0;
$imagen = $_POST['imagen'] ?? '';

if (empty($nombre) || $precio <= 0 || empty($imagen)) {
  // Redirigir si los datos son inválidos
  header("Location: productos.php");
  exit();
}

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
  $_SESSION['carrito'] = [];
}

// Buscar si el producto ya está en el carrito
$productoExistente = false;
foreach ($_SESSION['carrito'] as &$item) {
  if ($item['nombre'] === $nombre) {
    $item['cantidad']++;
    $productoExistente = true;
    break;
  }
}
unset($item);

// Si no existe, lo agregamos
if (!$productoExistente) {
  $_SESSION['carrito'][] = [
    'nombre' => $nombre,
    'precio' => $precio,
    'imagen' => $imagen,
    'cantidad' => 1
  ];
}

// Redirigir al carrito
header("Location: carrito.php");
exit();
