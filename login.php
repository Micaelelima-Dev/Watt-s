<?php
session_start();
include("includes/conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['usuario']);
    $senha = trim(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING));

    $sql = "SELECT * FROM usuarios WHERE nome_usuario = ?";
    $stmt = $conexao->prepare($sql);

    if ($stmt === false) {
        die("Erro na preparação da consulta: " . $conexao->error);
    }

    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $dados = $resultado->fetch_assoc();

        if (password_verify($senha, $dados['senha'])) {
            $_SESSION['usuario'] = $dados['nome_usuario'];
            header("Location: dashboard.php");
            exit();
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Usuário não encontrado!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login - Watt's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">


    <style>
    body {
        background-color: #ffffff;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #2f4f4f;
        margin: 0;
        padding: 0;
    }

    .login-container {
        max-width: 400px;
        margin: 80px auto;
        padding: 30px 35px;
        border: 1px solid #c8e6c9;
        border-radius: 10px;
        background-color: #f9fff9;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
    }

    .login-container img {
        display: block;
        width: 50%;
        height: auto;
        border-radius: 15px;
        margin-bottom: 15px;
    }

    h4 {
        color: #337a5b;
        font-weight: bold;
        text-align: center;
        margin-bottom: 25px;
    }

    label {
        font-weight: bold;
        color: #337a5b;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px 12px;
        font-size: 16px;
        border: 1.5px solid #b2dfdb;
        border-radius: 6px;
        transition: border-color 0.3s ease;
        margin-bottom: 16px;
        box-sizing: border-box;
    }

    input:focus {
        border-color: #4caf50;
        outline: none;
        box-shadow: 0 0 6px #4caf50aa;
    }

    .btn-primary {
        background-color: #4caf50;
        border: none;
        color: white;
        font-weight: bold;
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #388e3c;
    }

    .alert {
        background-color: #f44336;
        color: white;
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 15px;
        text-align: center;
    }
    </style>
</head>

<body>
    <div class="login-container">
        <img class="m-auto" src="cd2283c7-bfa2-4143-84cf-7c2c7b526132.jpg" alt="">
        <h4>Login - Watt's Soluções Elétricas <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                fill="currentColor" class="bi bi-lightning" viewBox="0 0 16 16">
                <path
                    d="M5.52.359A.5.5 0 0 1 6 0h4a.5.5 0 0 1 .474.658L8.694 6H12.5a.5.5 0 0 1 .395.807l-7 9a.5.5 0 0 1-.873-.454L6.823 9.5H3.5a.5.5 0 0 1-.48-.641zM6.374 1 4.168 8.5H7.5a.5.5 0 0 1 .478.647L6.78 13.04 11.478 7H8a.5.5 0 0 1-.474-.658L9.306 1z" />
            </svg> </h4>
        <?php if (isset($erro)): ?><div class="alert"><?=htmlspecialchars($erro) ?></div><?php endif;
    ?><form method="POST" action=""><label for="usuario">Usuário</label><input type="text" name="usuario" id="usuario"
                required><label for="senha">Senha</label><input type="password" name="senha" id="senha" required><button
                type="submit" class="btn btn-primary">Entrar</button></form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>

</body>


</html>