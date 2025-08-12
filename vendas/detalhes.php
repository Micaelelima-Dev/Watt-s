<?php
session_start();
include_once('../includes/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_funcionario = $_POST['id_funcionario'];
    $data_venda = $_POST['data_venda'];
    $produtos = $_POST['produtos'] ?? [];

    if (empty($produtos)) {
        $_SESSION['erro_venda'] = "Nenhum produto selecionado.";
        header("Location: cadastrar.php");
        exit;
    }

    // Validar estoque
    foreach ($produtos as $id_produto => $produto) {
        $quantidade = (int) $produto['quantidade'];

        // Buscar estoque atual
        $query = $conexao->prepare("SELECT quantidade_estoque FROM produtos WHERE id_produto = ?");
        $query->bind_param("i", $id_produto);
        $query->execute();
        $result = $query->get_result();
        $produto_bd = $result->fetch_assoc();

        if (!$produto_bd) {
            $_SESSION['erro_venda'] = "Produto com ID $id_produto não encontrado.";
            header("Location: cadastrar.php");
            exit;
        }

        if ($produto_bd['quantidade_estoque'] < $quantidade) {
            $_SESSION['erro_venda'] = "Estoque insuficiente para o produto ID $id_produto. Disponível: {$produto_bd['quantidade_estoque']}, solicitado: $quantidade.";
            header("Location: cadastrar.php");
            exit;
        }
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

    // Preparar statements
    $stmt_prod = $conexao->prepare("INSERT INTO vendas_produtos (id_venda, id_produto, quantidade_vendida, valor_unitario) VALUES (?, ?, ?, ?)");
    $stmt_estoque = $conexao->prepare("UPDATE produtos SET quantidade_estoque = quantidade_estoque - ? WHERE id_produto = ?");

    // Inserir produtos vendidos e atualizar estoque
    foreach ($produtos as $id_produto => $produto) {
        if (isset($produto['valor'], $produto['quantidade'])) {
            $quantidade = (int) $produto['quantidade'];
            $valor_unitario = (float) $produto['valor'];

            $stmt_prod->bind_param("iiid", $id_venda, $id_produto, $quantidade, $valor_unitario);
            $stmt_prod->execute();

            $stmt_estoque->bind_param("ii", $quantidade, $id_produto);
            $stmt_estoque->execute();
        }
    }

    header("Location: listar.php");
    exit;
}