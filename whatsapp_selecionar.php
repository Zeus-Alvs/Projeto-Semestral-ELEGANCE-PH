<?php
require 'config.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

// Verifica se marcou algum checkbox
if (!isset($_POST['selecionados']) || count($_POST['selecionados']) == 0) {
    header("Location: dashboard.php");
    exit;
}

// Gera código do pedido
$codigo_pedido = rand(100000, 999999);
$nome_cliente = $_SESSION['usuario_nome'];

// Mensagem inicial
$mensagem = "Codigo de pedido: {$codigo_pedido}\n";
$mensagem .= "Nome: {$nome_cliente}\n\n";
$mensagem .= "*ITENS DO PEDIDO:*\n\n";

$sql_update_vendas = "UPDATE produto SET vendidos = COALESCE(vendidos, 0) + ? WHERE id = ?";
$stmt_update_vendas = $pdo->prepare($sql_update_vendas);

// Prepara as queries de atualização do carrinho
$sql_busca_item = "SELECT c.produto_id, c.nomeproduto, c.tamanho, c.preco, c.quantidade FROM carrinho c WHERE c.id = ? AND c.usuario_id = ?";
$stmt_busca_item = $pdo->prepare($sql_busca_item);

$sql_update_carrinho = "UPDATE carrinho SET quantidade = ? WHERE id = ? AND usuario_id = ?";
$stmt_update_carrinho = $pdo->prepare($sql_update_carrinho);

$sql_delete_carrinho = "DELETE FROM carrinho WHERE id = ? AND usuario_id = ?";
$stmt_delete_carrinho = $pdo->prepare($sql_delete_carrinho);


// --- LOOP PRINCIPAL ---
// $id_item é o ID da linha no CARRINHO (não do produto)
foreach ($_POST['selecionados'] as $id_item => $valor) {

    // 1. Pega a quantidade que o usuário digitou no input
    // Se não tiver input, assume 1, mas seu HTML tem input.
    $quantidade_selecionada = isset($_POST['quantidade'][$id_item]) ? intval($_POST['quantidade'][$id_item]) : 1;

    // 2. Busca dados do item no carrinho
    $stmt_busca_item->execute([$id_item, $id_usuario]);
    $item = $stmt_busca_item->fetch(PDO::FETCH_ASSOC);

    if (!$item) continue; // Se der erro, pula pro próximo

    // Validação básica: não deixar vender mais do que tem no carrinho
    if ($quantidade_selecionada > $item['quantidade']) {
        $quantidade_selecionada = $item['quantidade'];
    }

    // 3. ATUALIZA A TABELA PRODUTO (VENDIDOS)
    // Aqui está a função que você pediu. Usamos o produto_id que veio do SELECT acima
    if (!empty($item['produto_id'])) {
        $stmt_update_vendas->execute([$quantidade_selecionada, $item['produto_id']]);
    }

    // 4. Formata mensagem do WhatsApp
    $preco_total = number_format($item['preco'] * $quantidade_selecionada, 2, ',', '.');
    
    $mensagem .= "Produto: {$item['nomeproduto']}\n";
    $mensagem .= "Tamanho: {$item['tamanho']}\n";
    $mensagem .= "Qtd: {$quantidade_selecionada}\n";
    $mensagem .= "Subtotal: R$ {$preco_total}\n";
    $mensagem .= "----------------------------\n";

    // 5. Atualiza ou Remove do Carrinho
    $quantidade_restante = $item['quantidade'] - $quantidade_selecionada;

    if ($quantidade_restante > 0) {
        // Se sobrou item no carrinho (compra parcial)
        $stmt_update_carrinho->execute([$quantidade_restante, $id_item, $id_usuario]);
    } else {
        // Se comprou tudo (ou selecionou remover tudo), apaga do carrinho
        $stmt_delete_carrinho->execute([$id_item, $id_usuario]);
    }
}

// Finaliza link do WhatsApp
$mensagem_url = urlencode($mensagem);
$numero_whatsapp = "5513988200915"; 

header("Location: https://wa.me/{$numero_whatsapp}?text={$mensagem_url}");
exit;
?>