<?php
require 'config.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

// Primeiro, remover todos os itens marcados com "remover todo"
if (isset($_POST['remover_todo'])) {
    foreach ($_POST['remover_todo'] as $id_item => $valor) {
        if ($valor == 1) {
            $delete = $pdo->prepare("DELETE FROM carrinho WHERE id = ? AND usuario_id = ?");
            $delete->execute([$id_item, $id_usuario]);
        }
    }
}

// Depois, remover a quantidade dos itens selecionados
if (isset($_POST['selecionados'])) {
    foreach ($_POST['selecionados'] as $id_item => $valor) {

        // Se já foi removido pelo "remover todo", pula
        if (isset($_POST['remover_todo'][$id_item]) && $_POST['remover_todo'][$id_item] == 1) {
            continue;
        }

        // Quantidade para remover
        $remover_qtd = intval($_POST['quantidade'][$id_item]);

        $query = $pdo->prepare("SELECT quantidade FROM carrinho WHERE id = ? AND usuario_id = ?");
        $query->execute([$id_item, $id_usuario]);
        $item = $query->fetch(PDO::FETCH_ASSOC);

        if (!$item) continue;

        $restante = $item['quantidade'] - $remover_qtd;

        if ($restante > 0) {
            $update = $pdo->prepare("UPDATE carrinho SET quantidade = ? WHERE id = ?");
            $update->execute([$restante, $id_item]);
        } else {
            $delete = $pdo->prepare("DELETE FROM carrinho WHERE id = ? AND usuario_id = ?");
            $delete->execute([$id_item, $id_usuario]);
        }
    }
}

header("Location: dashboard.php");
exit;
?>
