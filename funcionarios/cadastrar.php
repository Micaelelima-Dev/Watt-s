<?php
include_once('../includes/conexao.php'); // conexão
?>

<!DOCTYPE html>
<html lang="pt-br">


<head>
    <meta charset="UTF-8">
    <title>Cadastro de Funcionários | Watt’s</title>
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
                <input type="text" id="cpf" name="cpf" required>
            </div>

            <div class="form-group">
                <label for="data_contratacao">Data de Admissão:</label>
                <input type="date" id="data_contratacao" name="data_contratacao" required>
            </div>

            <button type="submit" name="cadastrar">Cadastrar</button>
        </form>

        <a href="../funcionarios/listar.php" class="btn-voltar"> <svg xmlns="http://www.w3.org/2000/svg" width="16"
                height="16" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5z" />
            </svg> Ir para lista de funcionários</a>
        <a href="../dashboard.php" class="btn-voltar"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
            </svg> Voltar para o Menu principal</a>

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
    if (cpf.length > 11) cpf = cpf.slice(0, 11);
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    e.target.value = cpf;
});
</script>

</html>