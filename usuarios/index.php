<?php
include_once("../includes/verifica_login.php");
include_once("../includes/conexao.php");

$sql = "SELECT * FROM usuarios WHERE status = 'ativo' ORDER BY id_usuario";
$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Usuários - Watt's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


</head>
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f4f9f6;
    margin: 0;
    padding: 0;
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
    color: #4caf50;
    margin-bottom: 30px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: left;
    background-color: #4CAF50;
}

th {
    background-color: #4CAF50;
    color: white;
}

tr:nth-child(even) {
    background-color: #4CAF50;
}

a {
    color: #4CAF50;
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
}

.btn-voltar {
    display: inline-block;
    margin-top: 20px;
    color: #4CAF50;
    text-decoration: none;

}
</style>

<body>

    <div class="container">
        <h3>Usuários Cadastrados</h3>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($usuario = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= $usuario['id_usuario'] ?></td>
                    <td><?= $usuario['nome_usuario'] ?></td>
                    <td>
                        <a href="editar.php?id_usuario=<?= $usuario['id_usuario'] ?>"
                            class="btn btn-warning btn-sm">Editar</a>
                        <a href="desativar.php?id_usuario=<?= $usuario['id_usuario'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Tem certeza que deseja desativar este usuário?');">Desativar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <a href="cadastrar.php" class="btn btn-success mb-3">Novo Usuário</a><br>
        <a href="../dashboard.php" class="btn-voltar"><i class="fa-solid fa-house icon"></i> Voltar para o Menu
            principal</a>

</body>

</html>