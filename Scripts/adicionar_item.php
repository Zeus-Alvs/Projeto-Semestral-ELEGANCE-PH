<?php
require 'config.php';
session_start();
if (!isset($_SESSION['usuario_id'])) {
  $cep = '00000-000';
} else {
  $cep = $_SESSION["usuario_cep"];
}
?>

<?php


if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../Templates/login.php");
    exit;
}

$id_usuario = $_SESSION['usuario_id'];


$id_produto = $_POST['id_produto'];
$nome = $pdo->prepare('SELECT nome FROM produto WHERE id = ?');
$nome->execute([$id_produto]);
$nomeitem = $nome->fetchColumn();

$preco = $pdo->prepare('SELECT preco FROM produto WHERE id = ?');
$preco->execute([$id_produto]);
$precoitem = $preco->fetchColumn();

$tamanho = $_POST['tamanho'];
$quantidade = $_POST['quantidade'];


$query = $pdo->prepare("SELECT * FROM carrinho WHERE usuario_id = ? AND produto_id = ? AND tamanho = ?");
$query->execute([$id_usuario, $id_produto, $tamanho]);
$item = $query->fetch(PDO::FETCH_ASSOC);

if ($item) {
    
    $novaQtd = $item['quantidade'] + $quantidade;
    $update = $pdo->prepare("UPDATE carrinho SET quantidade = ? WHERE id = ?");
    $update->execute([$novaQtd, $item['id']]);
} else {
    
    $insert = $pdo->prepare("INSERT INTO carrinho (usuario_id, produto_id, nomeproduto, preco, tamanho, quantidade) VALUES (?,?,?,?,?,?)");
    $insert->execute([$id_usuario, $id_produto, $nomeitem, $precoitem, $tamanho,$quantidade]);
}

header("Location: ../Templates/dashboard.php");
exit;
?>
