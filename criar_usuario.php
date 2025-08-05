<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>

</body>

</html>


<?php
include("./includes/conexao.php");

$usuario = trim($_POST["admin"]);
$senha = trim($_POST["123456"]);

$sql = "INSERT INTO usuarios (nome_usuario, senha) VALUES (?, ?)";
$stmt = $conexao->prepare($sql);

if ($stmt === false) {
    die("Erro ao preparar a query: " . $conexao->error);
}

$stmt->bind_param("ss", $usuario, $senha);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Usuário inserido com sucesso!";
} else {
    echo "Erro ao inserir usuário.";
}