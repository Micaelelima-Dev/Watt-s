<?php
include_once('../includes/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_funcionario = $_POST['id_funcionario'];
    $data_venda = $_POST['data_venda'];
    $produtos = $_POST['produtos'] ?? [];

    if (empty($produtos)) {
        die("Nenhum produto selecionado.");
    }

    // Calcular valor total
    $valor_total = 0;
    foreach ($produtos as $id_produto => $produto) {
        if (isset($produto['valor'], $produto['quantidade'])) {
            $valor_total += $produto['valor'] * $produto['quantidade'];
        }
    }

    // Inserir venda
    $stmt = $conexao->prepare("INSERT INTO vendas (id_funcionario, data_venda, valor_total) VALUES (?, ?, ?)");
    $stmt->bind_param("isd", $id_funcionario, $data_venda, $valor_total);
    $stmt->execute();
    $id_venda = $stmt->insert_id;

    // Inserir produtos vendidos
    $stmt_prod = $conexao->prepare("INSERT INTO vendas_produtos (id_venda, id_produto, quantidade_vendida) VALUES (?, ?, ?)");
    foreach ($produtos as $id_produto => $produto) {
        if (isset($produto['valor'], $produto['quantidade'])) {
            $quantidade = (int) $produto['quantidade'];
            $stmt_prod->bind_param("iii", $id_venda, $id_produto, $quantidade);
            $stmt_prod->execute();
        }
    }

    header("Location: listar.php");
    exit;
}
?>