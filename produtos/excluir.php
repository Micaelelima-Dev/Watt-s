<?php
include_once('../includes/conexao.php');

if (!isset($_GET['id_produto'])) {
    echo "ID inválido.";
    exit;
}

$id = $_GET['id_produto'];

$sql = "DELETE FROM produtos WHERE id_produto = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: listar.php");
    exit;
} else {
    echo "Erro ao excluir produto.";
}
?>