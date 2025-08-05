<?php
include_once('../includes/conexao.php');

// Consulta as metas com nome do funcionário
$sql = "SELECT m.id_meta, f.nome_funcionario, m.mes_meta, m.valor_meta 
        FROM metas m 
        JOIN funcionarios f ON m.id_funcionario = f.id_funcionario 
        ORDER BY m.mes_meta DESC";
$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Metas | Watt’s</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
    .container {
        max-width: 900px;
        margin: 40px auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #337a5b;
        margin-bottom: 30px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 12px;
        border-bottom: 1px solid #ccc;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
        color: #333;
    }

    .btn {
        padding: 6px 12px;
        border-radius: 4px;
        text-decoration: none;
        color: #fff;
        font-weight: bold;
    }

    .btn-editar {
        background-color: #4CAF50;
    }

    .btn-excluir {
        background-color: #f44336;
    }

    .btn-editar:hover {
        background-color: #45a049;
    }

    .btn-excluir:hover {
        background-color: #d32f2f;
    }

    .btn-cadastrar {
        display: inline-block;
        background-color: #4caf50;
        color: white;
        padding: 10px 18px;
        margin-top: 20px;
        text-decoration: none;
        border-radius: 4px;
        font-weight: bold;
    }

    .btn-cadastrar:hover {
        background-color: #167e19ff;
    }

    .btn-voltar {
        display: block;
        margin-top: 20px;
        text-align: center;
        color: #077910;
        text-decoration: none;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Metas Cadastradas</h2>

        <a href="cadastrar.php" class="btn-cadastrar">+ Nova Meta</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Funcionário</th>
                    <th>Mês</th>
                    <th>Valor da Meta</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody><br>

                <?php
                if ($resultado->num_rows > 0) {
                    while ($meta = $resultado->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $meta['id_meta'] . "</td>";
                        echo "<td>" . $meta['nome_funcionario'] . "</td>";
                        echo "<td>" . date('m/Y', strtotime($meta['mes_meta'])) . "</td>";
                        echo "<td>R$ " . number_format($meta['valor_meta'], 2, ',', '.') . "</td>";
                        echo "<td>
                                <a class='btn btn-editar' href='editar.php?id=" . $meta['id_meta'] . "'>Editar</a>
                                <a class='btn btn-excluir' href='excluir.php?id=" . $meta['id_meta'] . "' onclick='return confirm(\"Deseja realmente excluir esta meta?\")'>Excluir</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhuma meta cadastrada.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="../dashboard.php" class="btn-voltar"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
            </svg> Voltar para o Menu principal</a>
</body>
</div>

</html>