<?php
include("../includes/conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'] ?? '';
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $status = 1;

    if (!empty($nome) && !empty($usuario) && !empty($senha)) {
        // Verifica duplicidade de usuário
        $check = $conexao->prepare("SELECT id_usuario FROM usuarios WHERE nome_usuario = ?");
        $check->bind_param("s", $usuario);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            echo "<div style='color: red;'>Nome de usuário já está em uso. Escolha outro.</div>";
        } else {
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $conexao->prepare("INSERT INTO usuarios (nome_usuario, usuario, senha, status) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $nome, $usuario, $senhaHash, $status);

            if ($stmt->execute()) {
                echo "<div style='color: green;'>Usuário cadastrado com sucesso!</div>";
            } else {
                echo "<div style='color: red;'>Erro ao cadastrar usuário: " . $stmt->error . "</div>";
            }
            $stmt->close();
        }
        $check->close();
    } else {
        echo "<div style='color: red;'>Preencha todos os campos.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f4f9f6;
    margin: 0;
    padding: 0;
}

.mb-3 {

    color: #077910;

}

.container {
    max-width: 900px;
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
</style>

<body class="container">
    <h1>Cadastrar Usuário</h1>
    <form method="post">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome completo:</label>
            <input type="text" class="form-control" name="nome" id="nome" required>
        </div>
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuário:</label>
            <input type="text" class="form-control" name="usuario" id="usuario" required>
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha:</label>
            <input type="password" class="form-control" name="senha" id="senha" required>
        </div>
        <button type="submit" class="btn btn-success">Cadastrar</button>
        <a href="./index.php" class="btn btn-secondary">Voltar</a>
    </form>
</body>

</html>