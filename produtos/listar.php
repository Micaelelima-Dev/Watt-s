<?php
include_once('../includes/conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos | Watt’s</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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

    td {
        vertical-align: top;
    }

    td:last-child {
        white-space: nowrap;
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
        <a href="cadastrar.php" class="btn btn-cadastrar"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                fill="currentColor" class="bi bi-box-arrow-in-down" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M3.5 6a.5.5 0 0 0-.5.5v8a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-8a.5.5 0 0 0-.5-.5h-2a.5.5 0 0 1 0-1h2A1.5 1.5 0 0 1 14 6.5v8a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 14.5v-8A1.5 1.5 0 0 1 3.5 5h2a.5.5 0 0 1 0 1z" />
                <path fill-rule="evenodd"
                    d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
            </svg> Cadastrar Novo Produto</a>
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

                // confirm() direto no link para evitar ações acidentais de zeramento
                if ($resultado->num_rows > 0) {
                    while ($produto = $resultado->fetch_assoc()) { //Loop e renderização
                        echo "<tr>";
                        echo "<td>" . $produto['id_produto'] . "</td>";
                        echo "<td>" . $produto['nome_produto'] . "</td>";
                        echo "<td>R$ " . number_format($produto['valor_unitario'], 2, ',', '.') . "</td>";
                        echo "<td>" . $produto['quantidade_estoque'] . "</td>";
                        echo "<td>
                                <div style='display: flex; gap: 6px;'>
                                    <a class='btn btn-editar' href='editar.php?id=" . $produto['id_produto'] . "'>Editar</a>
                                    <a class='btn btn-excluir' href='excluir.php?id_produto=" . $produto['id_produto'] . "' onclick='return confirm(\"Tem certeza que deseja zerar este produto?\")'>Zerar</a> 
                                </div>
                            </td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum produto cadastrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <a href="../dashboard.php" class="btn-voltar"><i class="fa-solid fa-house icon"></i> Voltar para o Menu
            principal</a>
    </div>
</body>

</html>