<?php
session_start();

if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit();
}

if (isset($_GET['nombre'])) {
  $nombre = $_GET['nombre'];

  foreach ($_SESSION['carrito'] as $index => $item) {
    if ($item['nombre'] === $nombre) {
      unset($_SESSION['carrito'][$index]);
      $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar
      break;
    }
  }
}

header("Location: carrito.php");
exit();
