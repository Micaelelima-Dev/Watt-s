<?php
include_once('../includes/conexao.php');

$vendas = $conexao->query("
    SELECT v.*, f.nome_funcionario AS funcionario
    FROM vendas v
    JOIN funcionarios f ON v.id_funcionario = f.id_funcionario
    ORDER BY v.data_venda DESC
");

function getProdutosDaVenda($conexao, $id_venda) {
    $stmt = $conexao->prepare("
        SELECT p.nome_produto, p.valor_unitario, vp.quantidade_vendida
        FROM vendas_produtos vp
        JOIN produtos p ON vp.id_produto = p.id_produto
        WHERE vp.id_venda = ?
    ");
    $stmt->bind_param("i", $id_venda);
    $stmt->execute();
    return $stmt->get_result();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Lista de Vendas - Watt’s</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f2f7f5;
        margin: 0;
        padding: 20px;
        color: #333;
    }

    h2 {
        text-align: center;
        color: #2c5f2d;
    }

    a {
        display: inline-block;
        margin-bottom: 20px;
        background-color: #2c5f2d;
        color: #fff;
        padding: 10px 15px;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
    }

    a:hover {
        background-color: #3f7d3f;
    }

    .venda {
        background-color: #fff;
        border: 2px solid #cbe3cc;
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 20px;
        box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.05);
    }

    .venda strong {
        color: #2c5f2d;
    }

    ul {
        margin-top: 10px;
        padding-left: 20px;
    }

    ul li {
        margin-bottom: 5px;
    }

    .total {
        font-size: 16px;
        font-weight: bold;
        margin-top: 10px;
        color: #1e3e1e;
    }

    .btn-voltar {
        display: inline-block;
        background-color: #2c5f2d;
        color: #fff;
        padding: 10px 15px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .btn-voltar:hover {
        background-color: #3f7d3f;
    }
    </style>
</head>

<body>

    <h2>Vendas Realizadas</h2>
    <a href="cadastrar.php">+ Nova Venda</a>

    <?php while($v = $vendas->fetch_assoc()): ?>
    <div class="venda">
        <strong>Funcionário:</strong> <?= $v['funcionario'] ?><br>
        <strong>Data:</strong> <?= date('d/m/Y', strtotime($v['data_venda'])) ?><br>
        <strong>Produtos:</strong>
        <ul>
            <?php
                $produtos = getProdutosDaVenda($conexao, $v['id_venda']);
                while($p = $produtos->fetch_assoc()):
                    $subtotal = $p['valor_unitario'] * $p['quantidade_vendida'];
                ?>
            <li>
                <?= $p['nome_produto'] ?> - <?= $p['quantidade_vendida'] ?>x
                (R$<?= number_format($p['valor_unitario'], 2, ',', '.') ?>)
                = <strong>R$<?= number_format($subtotal, 2, ',', '.') ?></strong>
            </li>
            <?php endwhile; ?>
        </ul>
        <div class="total">Valor Total: R$<?= number_format($v['valor_total'], 2, ',', '.') ?></div>
    </div>
    <?php endwhile; ?>

    <a href="../dashboard.php" class="btn-voltar">← Voltar ao Menu Principal</a>


</body>

</html>