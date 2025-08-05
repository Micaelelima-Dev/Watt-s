<?php
include_once('../includes/conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos | Watt’s</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f4f9f6;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 900px;
        background-color: #ffffff;
        margin: 40px auto;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #337a5b;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 25px;
    }

    th,
    td {
        padding: 12px;
        border-bottom: 1px solid #ccc;
        text-align: left;
    }

    th {
        background-color: #e9f5ee;
        color: #2b2b2b;
    }

    tr:hover {
        background-color: #f2f2f2;
    }

    .btn {
        padding: 8px 12px;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
        text-decoration: none;
    }

    .btn-editar {
        background-color: #077910;
        color: white;
    }

    .btn-editar:hover {
        background-color: #337a5b;
    }

    .btn-excluir {
        background-color: #f44336;
        color: white;
    }

    .btn-excluir:hover {
        background-color: #d32f2f;
    }

    .btn-voltar {
        display: inline-block;
        margin-top: 20px;
        text-align: center;
        color: #4CAF50;
        text-decoration: none;
    }

    .btn-voltar:hover {
        text-decoration: underline;
    }

    .btn-cadastrar {
        background-color: #4CAF50;
        color: white;
        margin-bottom: 20px;
    }

    .btn-cadastrar:hover {
        background-color: #45a049;
    }
    </style>
</head>

<body>
    <div class="container">

        <h1>Produtos Cadastrados</h1>
        <a href="cadastrar.php" class="btn btn-cadastrar">+ Cadastrar Novo Produto</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do Produto</th>
                    <th>Valor Unitário (R$)</th>
                    <th>Estoque</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM produtos";
                $resultado = $conexao->query($sql);

                if ($resultado->num_rows > 0) {
                    while ($produto = $resultado->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $produto['id_produto'] . "</td>";
                        echo "<td>" . $produto['nome_produto'] . "</td>";
                        echo "<td>R$ " . number_format($produto['valor_unitario'], 2, ',', '.') . "</td>";
                        echo "<td>" . $produto['quantidade_estoque'] . "</td>";
                        echo "<td>
                                <a class='btn btn-editar' href='editar.php?id=" . $produto['id_produto'] . "'>Editar</a>
                                <a class='btn btn-excluir' href='excluir.php?id=" . $produto['id_produto'] . "' onclick='return confirm(\"Tem certeza que deseja excluir este produto?\")'>Excluir</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum produto cadastrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <a href="../dashboard.php" class="btn-voltar"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
            </svg> Voltar para o Menu principal</a>
    </div>
</body>

</html>