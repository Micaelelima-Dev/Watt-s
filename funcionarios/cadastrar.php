<?php
include_once('../includes/conexao.php'); // conexão
?>

<!DOCTYPE html>
<html lang="pt-br">


<head>
    <meta charset="UTF-8">
    <title>Cadastro de Funcionários | Watt’s</title>
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
        background-color: #077910;
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
        display: block;
        margin-top: 20px;
        text-align: center;
        color: #077910;
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
        <h1>Cadastrar Funcionário</h1>

        <form method="POST" action="cadastrar.php">
            <div class="form-group">
                <label for="nome">Nome do Funcionário:</label>
                <input type="text" id="nome_funcionario" name="nome" required>
            </div>

            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" maxlength="14" placeholder="000.000.000-00" required>
            </div>

            <div class="form-group">
                <label for="data_contratacao">Data de Contratação:</label>
                <input type="date" id="data_contratacao" name="data_contratacao" required>
            </div>

            <button type="submit" name="cadastrar">Cadastrar</button>
        </form>

        <a href="../funcionarios/listar.php" class="btn-voltar"><i class="fa-solid fa-arrow-left icon"></i> Ir para
            lista de funcionários</a>
        <a href="../dashboard.php" class="btn-voltar"><i class="fa-solid fa-house icon"></i> Voltar para o Menu
            principal</a>

        <?php
        if (isset($_POST['cadastrar'])) {
            // Leitura dos campos
            $nome_funcionario = $_POST['nome'];
            $cpf = $_POST['cpf'];
            $data_contratacao = $_POST['data_contratacao'];

        if ($conexao) {
            // Verifica se já existe CPF ou nome no banco
            $stmt_verifica = $conexao->prepare("SELECT * FROM funcionarios WHERE cpf = ?");
            $stmt_verifica->bind_param("s", $cpf);
            $stmt_verifica->execute();
            $resultado = $stmt_verifica->get_result();

            if ($resultado->num_rows > 0) {
                echo "<p class='mensagem' style='color: red;'>Erro: Já existe um funcionário cadastrado com este CPF.</p>";
            } else {
                // Cadastro permitido
                $stmt = $conexao->prepare("INSERT INTO funcionarios (nome_funcionario, cpf, data_contratacao, data_demissao, ativo) VALUES (?, ?, ?, NULL, 1)");
                $stmt->bind_param("sss", $nome_funcionario, $cpf, $data_contratacao);

                if ($stmt->execute()) {
                    echo "<p class='mensagem' style='color: green;'>Funcionário cadastrado com sucesso!</p>";
                } else {
                    echo "<p class='mensagem' style='color: red;'>Erro ao cadastrar funcionário: " . $stmt->error . "</p>";
                }
            }
        } else {
            echo "<p class='mensagem' style='color: red;'>Erro na conexão com o banco de dados.</p>";
        }
    }

        ?>
    </div>

</body>

<script>
//Js para formatação de cpf
document.getElementById('cpf').addEventListener('input', function(e) {
    let cpf = e.target.value.replace(/\D/g, '');
    if (cpf.length !== 11) cpf = cpf.slice(0, 11);
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    e.target.value = cpf;
});
</script>

</html>