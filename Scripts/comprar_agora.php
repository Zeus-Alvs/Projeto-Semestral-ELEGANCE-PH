<?php
require 'config.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../Templates/login.php");
    exit;
}


$id_produto = isset($_POST['id_produto']) ? intval($_POST['id_produto']) : (isset($_POST['id']) ? intval($_POST['id']) : null);

if (!$id_produto) {
    echo "Produto não especificado.";
    exit;
}

$tamanho = isset($_POST['tamanho']) ? $_POST['tamanho'] : 'Não informado';

$quantidade = isset($_POST['quantidade']) ? $_POST['quantidade'] : 1;

$stmt = $pdo->prepare("SELECT nome, preco, tipo, vendidos FROM produto WHERE id = ?");
$stmt->execute([$id_produto]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    echo "Produto não encontrado.";
    exit;
}

$qtde = $produto['vendidos'];
$update = $pdo->prepare("UPDATE produto SET vendidos = ? WHERE id = ?");
$update->execute([($qtde + $quantidade), $id_produto]);



$codigo_pedido = rand(100000, 999999);


$nome_cliente = $_SESSION['usuario_nome'];


$mensagem = "Código de pedido: {$codigo_pedido}\n";
$mensagem .= "Nome: {$nome_cliente}\n\n";
$mensagem .= "Produto: {$produto['nome']}\n";
$mensagem .= "Tamanho: {$tamanho}\n";
$mensagem .= "Quantidade: {$quantidade}\n";
$mensagem .= "Preço: R$ " . number_format($produto['preco'], 2, ',', '.') . "\n";
if (!empty($produto['descricao'])) {
    $mensagem .= "Descrição: {$produto['descricao']}\n";
}
$mensagem .= "----------------------------\n";


$mensagem_url = urlencode($mensagem);







header("Location: https://wa.me/5513988200915?text={$mensagem_url}");
exit;
?>
