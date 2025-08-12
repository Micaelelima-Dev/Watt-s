<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Watt's</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap + FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
    :root {
        --cor-clara: #e2f7ea;
        --cor-destaque: #38b000;
        --cor-texto: #337a5b;
        --cor-dark-bg: #1f1f1f;
        --cor-dark-text: #e0e0e0;
    }

    body {
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
        background-color: var(--cor-clara);
        transition: background-color 0.3s, color 0.3s;
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 240px;
        height: 100%;
        background-color: #c9f5dc;
        padding: 20px;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s;
    }

    .sidebar h4 {
        display: flex;
        align-items: center;
        font-weight: bold;
        color: var(--cor-destaque);
    }

    .sidebar h4 i {
        margin-right: 10px;
    }

    .sidebar a {
        display: block;
        margin-top: 20px;
        color: var(--cor-texto);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s;
    }

    .sidebar a:hover {
        text-decoration: underline;
    }

    .content {
        margin-left: 260px;
        padding: 40px;
    }

    .dark-mode {
        background-color: var(--cor-dark-bg);
        color: var(--cor-dark-text);
    }

    .dark-mode .sidebar {
        background-color: #2c2c2c;
    }

    .dark-mode .sidebar a {
        color: #ddd;
    }

    .btn-darkmode {
        position: absolute;
        top: 20px;
        right: 20px;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            padding: 10px;
        }

        .content {
            margin-left: 0;
            margin-top: 20px;
        }

        .sidebar a {
            margin-top: 0;
        }

        .btn-darkmode {
            position: relative;
            top: auto;
            right: auto;
            margin-top: 10px;
        }
    }
    </style>
</head>

<body>

    <div class="sidebar">
        <h4><i class="fas fa-bolt"></i>Watt’s</h4>
        <a href="./usuarios/index.php"><i class="fas fa-users"></i> Usuários</a>
        <a href="./funcionarios/listar.php"><i class="fas fa-user-tie"></i> Funcionários</a>
        <a href="./produtos/listar.php"><i class="fas fa-box-open"></i> Produtos</a>
        <a href="./metas/listar.php"><i class="fas fa-bullseye"></i> Metas</a>
        <a href="./vendas/cadastrar.php"><i class="fas fa-cash-register"></i> Vendas</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
    </div>

    <div class="content">
        <button class="btn btn-outline-secondary btn-sm btn-darkmode" onclick="alternarModo()">
            <i class="fas fa-moon"></i> Alternar Modo
        </button>
        <h2>Olá, <?= $_SESSION['usuario'] ?>!</h2>
        <p>Bem-vindo ao sistema da Watt’s Soluções Elétricas 🌿⚡</p>
    </div>

    <script>
    function alternarModo() {
        document.body.classList.toggle('dark-mode');
    }
    </script>
</body>

</html>