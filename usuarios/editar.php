<?php
include_once('../includes/conexao.php');

// Verifica se o ID foi passado na URL
if (!isset($_GET['id_usuario'])) {
    echo "<script>alert('Usuário não especificado'); window.location.href='../index.php';</script>";
    exit;
}

$id_usuario = intval($_GET['id_usuario']);

// Busca os dados do usuário
$sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo "<script>alert('Usuário não encontrado'); window.location.href='../index.php';</script>";
    exit;
}

$usuario = $resultado->fetch_assoc();

// Atualização, caso formulário seja enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_usuario = $_POST['nome_usuario'];

    $sql_update = "UPDATE usuarios SET nome_usuario = ? WHERE id_usuario = ?";
    $stmt_update = $conexao->prepare($sql_update);
    $stmt_update->bind_param("si", $nome_usuario, $id_usuario);

    if ($stmt_update->execute()) {
        echo "<script>alert('Usuário atualizado com sucesso'); window.location.href='../index.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar usuário');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <title>Editar Usuário - Watt’s</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
    body {
        background-color: rgb(255, 255, 255);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #2f4f4f;
        margin: 0;
        padding: 0;
    }

    h3 {
        color: #337a5b;
        font-weight: bold;
        text-align: center;
        margin-top: 40px;
        margin-bottom: 30px;
    }

    .container {
        max-width: 480px;
        margin: 0 auto 60px auto;
        padding: 30px 35px;
        border: 1px solid #c8e6c9;
        border-radius: 8px;
        background-color: #f9fff9;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #337a5b;
        font-size: 1.1em;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px 12px;
        font-size: 16px;
        border: 1.5px solid #b2dfdb;
        border-radius: 6px;
        color: #2f4f4f;
        transition: border-color 0.3s ease;
        box-sizing: border-box;
    }

    input[type="text"]:focus {
        border-color: #4caf50;
        outline: none;
        box-shadow: 0 0 6px #4caf50aa;
    }

    .btn {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-weight: 600;
        padding: 12px 26px;
        font-size: 16px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        margin-top: 20px;
        user-select: none;
        transition: background-color 0.3s ease;
        display: inline-block;
        text-align: center;
        text-decoration: none;
        background-color: #4caf50;
    }

    .btn-primary {
        background-color: #4caf50;
        border-color: #4caf50;
        color: white;
        margin-right: 10px;
    }

    .btn-primary:hover {
        background-color: #388e3c;
    }

    .btn-secondary {
        background-color: #b2dfdb;
        border-color: #b2dfdb;
        color: #004d40;
        text-decoration: none;
    }

    .btn-secondary:hover {
        background-color: #80cbc4;
    }

    .btn-voltar {
        display: inline-block;
        margin-top: 20px;
        color: #4CAF50;
        text-decoration: none;

    }
    </style>
</head>

<body>
    <div class="container">
        <h3>Editar Usuário</h3>
        <form method="POST">
            <label for="nome_usuario">Nome do Usuário:</label>
            <input type="text" id="nome_usuario" name="nome_usuario"
                value="<?= htmlspecialchars($usuario['nome_usuario']) ?>" required />

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a><br>
            <a href="../dashboard.php" class="btn-voltar"><i class="fa-solid fa-house icon"></i> Voltar para o Menu
                principal</a>
        </form>
    </div>
</body>

</html>