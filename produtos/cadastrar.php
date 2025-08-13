<?php
include_once('../includes/conexao.php');
include('../includes/verifica_login.php'); 
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Produto | Watt’s</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f4f9f6;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 600px;
        background-color: #ffffff;
        margin: 40px auto;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #337a5b;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 6px;
        color: #444;
    }

    input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        transition: 0.3s;
    }

    input:focus {
        border-color: #4CAF50;
        outline: none;
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        font-weight: bold;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        background-color: #45a049;
    }

    .btn-voltar {
        display: inline-block;
        margin-top: 20px;
        text-align: center;
        color: #4CAF50;
        text-decoration: none;
    }

    .btn-voltar:hover {
        text-decoration: underline;
    }

    .mensagem {
        margin-top: 20px;
        text-align: center;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Cadastrar Produto</h1>

        <form method="POST" action="">
            <div class="form-group">
                <label for="nome_produto">Nome do Produto:</label>
                <input type="text" id="nome_produto" name="nome_produto" required>
            </div>

            <div class="form-group">
                <label for="valor_unitario">Valor Unitário (R$):</label>
                <input type="number" step="0.01" id="valor_unitario" name="valor_unitario" required>
            </div>

            <div class="form-group">
                <label for="quantidade_estoque">Quantidade em Estoque:</label>
                <input type="number" id="quantidade_estoque" name="quantidade_estoque" required>
            </div>

            <button type="submit" name="cadastrar">Salvar Produto</button>
        </form>

        <a href="listar.php" class="btn-voltar"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5z" />
            </svg> Ir para lista de produtos</a><br>
        <a href="../dashboard.php" class="btn-voltar"><i class="fa-solid fa-house icon"></i> Voltar para o Menu
            principal</a>

        <?php
if (isset($_POST['cadastrar'])) {
    $nome = $_POST['nome_produto'];
    $valor = $_POST['valor_unitario'];
    $quantidade = $_POST['quantidade_estoque'];

    if ($quantidade < 0) { // condição caso o estoque for negativo, se sim retorna mensagem senão cadastra o produto
        echo "<p class='mensagem' style='color: red;'>Quantidade em estoque não pode ser negativa!</p>";
    } else {
        $stmt = $conexao->prepare("INSERT INTO produtos (nome_produto, valor_unitario, quantidade_estoque) VALUES (?, ?, ?)");
        $stmt->bind_param("sdi", $nome, $valor, $quantidade);

        if ($stmt->execute()) {
            echo "<p class='mensagem' style='color: green;'>Produto cadastrado com sucesso!</p>";
        } else {
            echo "<p class='mensagem' style='color: red;'>Erro ao cadastrar produto: " . $stmt->error . "</p>";
        }
    }
}
?>
    </div>
</body>

</html>