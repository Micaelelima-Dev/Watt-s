<?php
include('../includes/conexao.php');

// Verifica se o ID do funcionário foi enviado pela URL
if (isset($_GET['funcionario']) && is_numeric($_GET['funcionario'])) {
    $id_funcionario = $_GET['funcionario'];

    // Atualiza o funcionário para inativo (demitido)
    $sql = "UPDATE funcionarios SET ativo = 0, data_demissao = NOW() WHERE id_funcionario = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_funcionario);

    if ($stmt->execute()) {
        echo "<script>
            alert('Funcionário demitido com sucesso!');
            window.location.href = 'listar.php';
        </script>";
    } else {
        echo "<script>
            alert('Erro ao demitir o funcionário.');
            window.location.href = 'listar.php';
        </script>";
    }
} else {
    echo "<script>
        alert('Funcionário não especificado.');
        window.location.href = 'listar.php';
    </script>";
}
?>