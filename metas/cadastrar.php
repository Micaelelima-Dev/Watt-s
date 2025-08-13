<?php
include_once('../includes/conexao.php');


$funcionarios = $conexao->query("SELECT * FROM funcionarios WHERE ativo = 1");


$erro = '';

if (isset($_POST['cadastrar'])) {
    $id_func = $_POST['funcionario'];
    $mes = $_POST['mes'];
    $valor = $_POST['valor'];

    // Verificar se meta já existe
    $verifica = $conexao->prepare("SELECT id_meta FROM metas WHERE id_funcionario = ? AND mes_meta = ?");
    $verifica->bind_param("is", $id_func, $mes);
    $verifica->execute();
    $verifica->bind_result($id_meta_existente);
    $verifica->fetch();
    $verifica->close();

    if ($id_meta_existente) {
        // Atualiza meta
        $atualiza = $conexao->prepare("UPDATE metas SET valor_meta = ? WHERE id_meta = ?");
        $atualiza->bind_param("di", $valor, $id_meta_existente);
        $atualiza->execute();
    } else {
        // Insere nova meta
        $insere = $conexao->prepare("INSERT INTO metas (id_funcionario, mes_meta, valor_meta) VALUES (?, ?, ?)");
        $insere->bind_param("isd", $id_func, $mes, $valor);
        $insere->execute();
    }

    header("Location: listar.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Meta | Watt’s</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


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
            <a href="../metas/listar.php" class="btn-voltar"><i class="fa-solid fa-arrow-left icon"></i> Ir para
                lista de metas</a>
            <a href="../dashboard.php" class="btn-voltar"><i class="fa-solid fa-house icon"></i> Voltar para o Menu
                principal</a>

            <?php if ($erro): ?>
            <div style="background-color:#f8d7da; color:#842029; padding:10px; border-radius:5px; margin-bottom:15px;">
                <?= htmlspecialchars($erro) ?>
            </div>
            <?php endif; ?>


        </form>
    </div>

</body>

</html>