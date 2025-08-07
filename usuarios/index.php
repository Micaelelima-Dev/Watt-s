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
    <link rel="stylesheet" href="../css/style.css">
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
    background-color: #026b0aff;
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
        <a href="cadastrar.php" class="btn btn-success mb-3">Novo Usuário</a>
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
        <a href="../dashboard.php" class="btn btn-voltar mb-3"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                height="16" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
            </svg> Voltar</a>
    </div>

</body>

</html>