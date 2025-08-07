<?php
include('../includes/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_funcionario'], $_POST['acao'])) {
        $id = intval($_POST['id_funcionario']);
        $acao = $_POST['acao'];

        if ($acao === 'demitir') {
            $sql = "UPDATE funcionarios SET ativo = 0, data_demissao = NOW() WHERE id_funcionario = ?";
        } elseif ($acao === 'ativar') {
            $sql = "UPDATE funcionarios SET ativo = 1, data_demissao = NULL WHERE id_funcionario = ?";
        } else {
            echo "<script>alert('Ação inválida.'); window.location.href='listar.php';</script>";
            exit;
        }

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $msg = $acao === 'demitir' ? 'Funcionário demitido com sucesso!' : 'Funcionário ativado com sucesso!';
            echo "<script>alert('$msg'); window.location.href='listar.php';</script>";
        } else {
            echo "<script>alert('Erro ao atualizar funcionário.'); window.location.href='listar.php';</script>";
        }
    } else {
        echo "<script>alert('Dados incompletos.'); window.location.href='listar.php';</script>";
    }
} else {
    echo "<script>alert('Método inválido.'); window.location.href='listar.php';</script>";
}
?>