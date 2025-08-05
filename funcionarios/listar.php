<?php
include('../includes/conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Lista de Funcionários | Watt’s</title>
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
        color: #077910;
        margin-bottom: 30px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 12px 15px;
        border: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    a {
        color: #4CAF50;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        text-decoration: underline;
    }

    .btn-voltar {
        display: inline-block;
        margin-top: 20px;
        color: #4CAF50;
        text-decoration: none;
        font-weight: bold;
    }

    .btn-voltar:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Lista de Funcionários</h1>

        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Data de Admissão</th>
                    <th>Ativo</th>
                    <th>Data de Demissão</th> <!-- NOVO -->
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
            $sql = "SELECT id_funcionario, nome_funcionario, cpf, data_contratacao, ativo, data_demissao 
                    FROM funcionarios 
                    ORDER BY nome_funcionario ASC";
            $resultado = $conexao->query($sql);

            if ($resultado && $resultado->num_rows > 0) {
                while ($func = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($func['nome_funcionario']) . "</td>";
                    echo "<td>" . htmlspecialchars($func['cpf']) . "</td>";
                    echo "<td>" . htmlspecialchars(date('d/m/Y', strtotime($func['data_contratacao']))) . "</td>";
                    echo "<td>" . ($func['ativo'] ? 'Sim' : 'Não') . "</td>";
                    echo "<td>" . 
                        (!empty($func['data_demissao']) 
                            ? htmlspecialchars(date('d/m/Y', strtotime($func['data_demissao']))) 
                            : '—') 
                        . "</td>";
                    echo "<td>
                            <a href='editar.php?id=" . $func['id_funcionario'] . "'>Editar</a> | 
                            <a href='demitir.php?funcionario=" . $func['id_funcionario'] . "' onclick=\"return confirm('Tem certeza que deseja desativar este funcionário?');\">Demitir</a>
                        </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align:center;'>Nenhum funcionário cadastrado.</td></tr>";
            }
            ?>
            </tbody>
        </table>

        <a href="cadastrar.php" class="btn-voltar">
            <!-- ícone de cadastrar -->
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-person-fill-add" viewBox="0 0 16 16">
                <path
                    d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                <path
                    d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4" />
            </svg> Cadastrar novo funcionário
        </a><br>

        <a href="../dashboard.php" class="btn-voltar">
            <!-- ícone de voltar -->
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
            </svg> Voltar para o Menu principal
        </a>
    </div>
</body>

</html>