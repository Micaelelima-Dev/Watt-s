<?php
include_once('../includes/conexao.php');


$funcionarios = $conexao->query("SELECT * FROM funcionarios WHERE ativo = 1");


if (isset($_POST['cadastrar'])) {
    $id_func = $_POST['funcionario'];
    $mes = $_POST['mes'];
    $valor = $_POST['valor'];

    
    $sql = "INSERT INTO metas (id_funcionario, mes_meta, valor_meta) VALUES (?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("isd", $id_func, $mes, $valor);
    $stmt->execute();

    header("Location: listar.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Meta | Watt’s</title>
    <link rel="stylesheet" href="../assets/estilo_padrao.css">
    <style>
    .container {
        max-width: 600px;
        background-color: #ffffff;
        margin: 40px auto;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #337a5b;
        margin-bottom: 30px;
    }

    form label {
        font-weight: bold;
        color: #444;
        display: block;
        margin-top: 15px;
    }

    select,
    input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button {
        width: 100%;
        padding: 12px;
        margin-top: 20px;
        background-color: #4CAF50;
        color: white;
        font-weight: bold;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
    }

    .btn-voltar {
        display: block;
        margin-top: 20px;
        text-align: center;
        color: #077910;
        text-decoration: none;
    }

    .btn-voltar:hover {
        background-color: #bbb;
    }
    </style>
</head>

<body>

    <div class="container">
        <h2>Cadastrar Nova Meta</h2>
        <form method="POST">
            <label for="funcionario">Funcionário:</label>
            <select name="funcionario" id="funcionario" required>
                <option value="">Selecione</option>
                <?php while ($f = $funcionarios->fetch_assoc()) { ?>
                <option value="<?= $f['id_funcionario'] ?>"><?= $f['nome_funcionario'] ?></option>
                <?php } ?>
            </select>

            <label for="mes">Mês da Meta:</label>
            <input type="month" name="mes" id="mes" required>

            <label for="valor">Valor da Meta (R$):</label>
            <input type="number" step="0.01" name="valor" id="valor" required>

            <button type="submit" name="cadastrar">Cadastrar</button>
            <a href="listar.php" class="btn-voltar"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5z" />
                </svg>
                Ir á lista de metas</a>
            <a href="../dashboard.php" class="btn-voltar"> <svg xmlns="http://www.w3.org/2000/svg" width="16"
                    height="16" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
                </svg> Voltar para o Menu principal</a>

        </form>
    </div>

</body>

</html>