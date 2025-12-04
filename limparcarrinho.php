<?php
require 'config.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

$del = $pdo->prepare("DELETE FROM carrinho WHERE usuario_id = ?");
$del->execute([$id_usuario]);

header("Location: dashboard.php");
exit;
?>
