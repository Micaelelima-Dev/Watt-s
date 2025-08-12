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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

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


    .btn-voltar {
        display: block;
        margin-top: 20px;
        text-align: center;
        color: #077910;

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
                                <a class='btn btn-editar' href='editar.php?id_meta=" . $meta['id_meta'] . "'>Editar</a>
                                <a class='btn btn-excluir' href='excluir.php?id_meta=" . $meta['id_meta'] . "' onclick='return confirm(\"Deseja realmente excluir esta meta?\")'>Excluir</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhuma meta cadastrada.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="../dashboard.php" class="btn-voltar"><i class="fa-solid fa-house icon"></i> Voltar para o Menu
            principal</a>
</body>
</div>

</html>