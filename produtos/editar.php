<?php
include_once('../includes/conexao.php');

// Verifica se foi enviado o ID via GET corretamente
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Produto não encontrado.";
    exit;
}

$id = intval($_GET['id']);

// Consulta segura com prepared statement
$sql = "SELECT * FROM produtos WHERE id_produto = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$produto = $resultado->fetch_assoc();

if (!$produto) {
    echo "Produto não encontrado.";
    exit;
}

// Atualiza os dados se o formulário for enviado
if (isset($_POST['atualizar'])) {
    $nome = $_POST['nome'];
    $valor = floatval($_POST['valor']);
    $quantidade = intval($_POST['quantidade']);

if ($quantidade < 0) {
    echo "<script>alert('A quantidade não pode ser negativa.'); window.history.back();</script>";
    exit;
}

$sqlUpdate = "UPDATE produtos SET nome_produto = ?, valor_unitario = ?, quantidade_estoque = ? WHERE id_produto = ?";

    $stmtUpdate = $conexao->prepare($sqlUpdate);
    $stmtUpdate->bind_param("sdii", $nome, $valor, $quantidade, $id);

    if ($stmtUpdate->execute()) {
        header("Location: listar.php");
        exit;
    } else {
        echo "Erro ao atualizar produto.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Produto | Watt’s</title>
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
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
        color: #444;
    }

    input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: #077910;
        color: white;
        font-weight: bold;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0c744a;
    }

    .btn-voltar {
        display: inline-block;
        margin-top: 15px;
        padding: 10px 20px;
        background-color: #f0f0f0;
        color: #333;
        text-decoration: none;
        border-radius: 4px;
        font-weight: bold;
        text-align: center;
        color: #077910;
    }

    .btn-voltar:hover {
        background-color: #bbb;
    }
    </style>
</head>

<body>

    <div class="container">
        <h1>Editar Produto</h1>

        <form method="POST">
            <div class="form-group">
                <label>Nome do Produto:</label>
                <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome_produto']) ?>" required>
            </div>
            <div class="form-group">
                <label>Valor Unitário:</label>
                <input type="number" step="0.01" name="valor" value="<?= $produto['valor_unitario'] ?>" required>
            </div>
            <div class="form-group">
                <label>Quantidade em Estoque:</label>
                <input type="number" name="quantidade" value="<?= $produto['quantidade_estoque'] ?>" required>
            </div>

            <button type="submit" name="atualizar">Salvar Alterações</button>
            <a href="listar.php" class="btn-voltar"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
                </svg> Voltar para produtos cadastrados</a>
        </form>
    </div>

</body>

</html>