<?php
include_once('../includes/conexao.php');

if (!isset($_GET['id_produto'])) {
    echo "ID inválido.";
    exit;
}

$id = $_GET['id_produto'];

// Atualiza a quantidade em estoque para zero
$sql = "UPDATE produtos SET quantidade_estoque = 0 WHERE id_produto = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: listar.php");
    exit;
} else {
    echo "Erro ao zerar estoque do produto.";
}
?>
