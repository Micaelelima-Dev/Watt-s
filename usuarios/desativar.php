<?php
include_once("../includes/conexao.php");

if (isset($_GET['id_usuario'])) {
    $id = $_GET['id_usuario'];

    $sql = "UPDATE usuarios SET status = 'inativo' WHERE id_usuario = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../index.php?msg=usuario_desativado");
        exit();
    } else {
        echo "Erro ao desativar usuário.";
    }
} else {
    echo "ID não fornecido.";
}
?>