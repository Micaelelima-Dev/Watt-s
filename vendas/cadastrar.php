<?php
session_start();

$erro = '';
if (isset($_SESSION['erro_venda'])) {
    $erro = $_SESSION['erro_venda'];
    unset($_SESSION['erro_venda']);
}


include_once('../includes/conexao.php');


// Buscar funcionários ativos
$funcionarios = $conexao->query("SELECT * FROM funcionarios WHERE ativo = 1");

// Buscar produtos
$produtos = $conexao->query("SELECT * FROM produtos WHERE quantidade_estoque > 0");

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Nova Venda - Watt’s</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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

    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 12px;
        border: 2px solid #cbe3cc;
        max-width: 700px;
        margin: 0 auto;
        box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.05);
    }

    label {
        font-weight: bold;
        color: #2c5f2d;
        display: block;
        margin-top: 10px;
    }

    select,
    input[type="date"],
    input[type="number"] {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    .produto-item {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 10px;
        background-color: #f9fdf9;
    }

    button {
        background-color: #2c5f2d;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 15px;
    }

    button:hover {
        background-color: #3f7d3f;
    }

    a.voltar,
    a.menu {
        display: inline-block;
        margin-top: 20px;
        background-color: #888;
        color: #fff;
        padding: 8px 15px;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
    }

    a.voltar:hover,
    a.menu:hover {
        background-color: #555;
    }

    .icon {
        margin-right: 6px;
        color: #2c5f2d;
    }
    </style>
</head>

<body>

    <h2><i class="fa-solid fa-cart-plus icon"></i>Nova Venda</h2>

    <?php if ($erro): ?>
    <div style="
        background-color: #fdecea;
        color: #b71c1c;
        border: 1px solid #f5c6cb;
        padding: 12px 20px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-weight: 600;
        box-shadow: 0 2px 6px rgba(183, 28, 28, 0.2);
        display: flex;
        align-items: center;
        gap: 10px;
    ">
        <span style="font-size: 1.4rem;">❌</span>
        <span><?= htmlspecialchars($erro) ?></span>
    </div>
    <?php endif; ?>


    <form action="detalhes.php" method="POST">

        <label><i class="fa-solid fa-user icon"></i>Funcionário:</label>
        <select name="id_funcionario" required>
            <option value="">Selecione</option>
            <?php while($f = $funcionarios->fetch_assoc()): ?>
            <option value="<?= $f['id_funcionario'] ?>"><?= $f['nome_funcionario'] ?></option>
            <?php endwhile; ?>
        </select>

        <label><i class="fa-solid fa-calendar-days icon"></i>Data da Venda:</label>
        <input type="date" name="data_venda" required>

        <label><i class="fa-solid fa-boxes-stacked icon"></i>Produtos:</label>

        <?php
        if ($produtos && $produtos->num_rows > 0):
            while($p = $produtos->fetch_assoc()):
                $id = $p['id_produto'];
                $nome = $p['nome_produto'];
                $valor = $p['valor_unitario'];
        ?>
        <div class="produto-item">
            <input type="checkbox" name="produtos[<?= $id ?>][valor]" value="<?= $valor ?>">
            <?= $nome ?> (R$<?= number_format($valor, 2, ',', '.') ?>)
            <br>
            <label>Qtd:</label>
            <input type="number" name="produtos[<?= $id ?>][quantidade]" value="1" min="1" style="width: 70px;">
        </div>
        <?php
            endwhile;
        else:
            echo "<p>Nenhum produto disponível.</p>";
        endif;
        ?>


        <button type="submit"><i class="fa-solid fa-floppy-disk icon"></i>Salvar Venda</button>
    </form>

    <div style="text-align: center;">
        <a href="listar.php" class="voltar"><i class="fa-solid fa-arrow-left icon"></i>Ver Vendas</a>
        <a href="../dashboard.php" class="menu"><i class="fa-solid fa-house icon"></i>Menu Principal</a>
    </div>

</body>

</html>