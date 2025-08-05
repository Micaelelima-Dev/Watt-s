<?php
include("./includes/conexao.php");

$usuario = "admin";
$senha = password_hash("123456", PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nome_usuario, senha) VALUES (?, ?)";
$stmt = $conexao->prepare($sql);

if ($stmt === false) {
    die("Erro ao preparar a query: " . $conexao->error);
}

$stmt->bind_param("ss", $usuario, $senha);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Usuário admin criado com sucesso!";
} else {
    echo "Erro ao criar usuário admin.";
}
?>