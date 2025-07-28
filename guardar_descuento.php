<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['descuento'])) {
  $_SESSION['descuento_ruleta'] = $_POST['descuento'];
}
?>
