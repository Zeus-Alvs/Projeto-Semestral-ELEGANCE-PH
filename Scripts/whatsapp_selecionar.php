<?php
require 'config.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../Templates/dashboard.php");
    exit;
}

$id_usuario = $_SESSION['usuario_id'];


if (!isset($_POST['selecionados']) || count($_POST['selecionados']) == 0) {
    header("Location: ../Templates/dashboard.php");
    exit;
}

$codigo_pedido = rand(100000, 999999);
$nome_cliente = $_SESSION['usuario_nome'];


$mensagem = "Codigo de pedido: {$codigo_pedido}\n";
$mensagem .= "Nome: {$nome_cliente}\n\n";
$mensagem .= "*ITENS DO PEDIDO:*\n\n";

$sql_update_vendas = "UPDATE produto SET vendidos = COALESCE(vendidos, 0) + ? WHERE id = ?";
$stmt_update_vendas = $pdo->prepare($sql_update_vendas);


$sql_busca_item = "SELECT c.produto_id, c.nomeproduto, c.tamanho, c.preco, c.quantidade FROM carrinho c WHERE c.id = ? AND c.usuario_id = ?";
$stmt_busca_item = $pdo->prepare($sql_busca_item);

$sql_update_carrinho = "UPDATE carrinho SET quantidade = ? WHERE id = ? AND usuario_id = ?";
$stmt_update_carrinho = $pdo->prepare($sql_update_carrinho);

$sql_delete_carrinho = "DELETE FROM carrinho WHERE id = ? AND usuario_id = ?";
$stmt_delete_carrinho = $pdo->prepare($sql_delete_carrinho);


foreach ($_POST['selecionados'] as $id_item => $valor) {

    $quantidade_selecionada = isset($_POST['quantidade'][$id_item]) ? intval($_POST['quantidade'][$id_item]) : 1;

   
    $stmt_busca_item->execute([$id_item, $id_usuario]);
    $item = $stmt_busca_item->fetch(PDO::FETCH_ASSOC);

    if (!$item) continue; 

    
    if ($quantidade_selecionada > $item['quantidade']) {
        $quantidade_selecionada = $item['quantidade'];
    }

    if (!empty($item['produto_id'])) {
        $stmt_update_vendas->execute([$quantidade_selecionada, $item['produto_id']]);
    }


    $preco_total = number_format($item['preco'] * $quantidade_selecionada, 2, ',', '.');
    
    $mensagem .= "Produto: {$item['nomeproduto']}\n";
    $mensagem .= "Tamanho: {$item['tamanho']}\n";
    $mensagem .= "Qtd: {$quantidade_selecionada}\n";
    $mensagem .= "Subtotal: R$ {$preco_total}\n";
    $mensagem .= "----------------------------\n";


    $quantidade_restante = $item['quantidade'] - $quantidade_selecionada;

    if ($quantidade_restante > 0) {

        $stmt_update_carrinho->execute([$quantidade_restante, $id_item, $id_usuario]);
    } else {

        $stmt_delete_carrinho->execute([$id_item, $id_usuario]);
    }
}


$mensagem_url = urlencode($mensagem);
$numero_whatsapp = "5513988200915"; 

header("Location: https://wa.me/{$numero_whatsapp}?text={$mensagem_url}");
exit;
?>