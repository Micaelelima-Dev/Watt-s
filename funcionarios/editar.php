<?php
include('../includes/conexao.php');

// Verifica se veio o ID pela URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Funcionário não especificado.";
    exit;
}

$id = $_GET['id'];

// Busca os dados do funcionário
$sql = "SELECT * FROM funcionarios WHERE id_funcionario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows != 1) {
    echo "Funcionário não encontrado.";
    exit;
}

$funcionario = $resultado->fetch_assoc();

$data_demissao = $funcionario['data_demissao'] ?? null;
$data_demissao_preenchida = $data_demissao ? $data_demissao : date('Y-m-d');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $data_contratacao = $_POST['data_contratacao'];
    $data_demissao = $_POST['data_demissao'];
    $data_demissao = empty($data_demissao) ? null : $data_demissao;

    $sqlUpdate = "UPDATE funcionarios SET nome_funcionario = ?, cpf = ?, data_contratacao = ?, data_demissao = ? WHERE id_funcionario = ?";
    $stmtUpdate = $conexao->prepare($sqlUpdate);
    $stmtUpdate->bind_param("ssssi", $nome, $cpf, $data_contratacao, $data_demissao, $id);

    if ($stmtUpdate->execute()) {
        echo "<script>alert('Funcionário atualizado com sucesso!'); window.location.href='listar.php';</script>";
    } else {
        echo "Erro ao atualizar: " . $stmtUpdate->error;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Funcionário</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f0fdf5;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 600px;
        background-color: #ffffff;
        margin: 40px auto;
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #337a5b;
    }

    label {
        display: block;
        font-weight: bold;
        margin-top: 15px;
        color: #333;
    }

    input[type="text"],
    input[type="date"] {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 12px 20px;
        margin-top: 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        font-weight: bold;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    a {
        display: inline-block;
        margin-top: 20px;
        color: #4CAF50;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Editar Funcionário</h1>
        <form method="POST">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required
                value="<?= htmlspecialchars($funcionario['nome_funcionario']) ?>">

            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" required value="<?= htmlspecialchars($funcionario['cpf']) ?>">

            <label for="data_contratacao">Data de Contratação:</label>
            <input type="date" name="data_contratacao" id="data_contratacao" required
                value="<?= $funcionario['data_contratacao'] ?>">
            <label for="data_demissao">Data de Demissão:</label>
            <input type="date" name="data_demissao" id="data_demissao"
                value="<?= htmlspecialchars($data_demissao_preenchida) ?>">


            <input type="submit" value="Salvar Alterações">
        </form>

        <a href="listar.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
            </svg> Voltar à lista de funcionários</a>
    </div>
</body>

</html>