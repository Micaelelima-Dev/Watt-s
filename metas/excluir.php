<?php
include_once('../includes/conexao.php');

if (!isset($_GET['id_meta'])) {
    echo "ID inválido.";
    exit;
}

$id = $_GET['id_meta'];

$sql = "DELETE FROM metas WHERE id_meta = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: listar.php");
    exit;
} else {
    echo "<div style='color:red;'>Erro ao excluir meta.</div>";
}
?>