<?php
require 'config.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['nivel'] !== 'admin') {
    header("Location: home.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: editarprodutos.php");
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM produto WHERE id = ?");
$stmt->execute([$id]);

header("Location: editarprodutos.php");
exit;
