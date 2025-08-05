<?php
include_once('../includes/conexao.php');

if (!isset($_GET['id_meta'])) {
    echo "ID inválido.";
    exit;
}

$id = $_GET['id_meta'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mes_meta = $_POST['mes_meta'] ?? '';
    $valor_meta = $_POST['valor_meta'] ?? '';

    if (!empty($mes_meta) && is_numeric($valor_meta)) {
        $sql = "UPDATE metas SET mes_meta = ?, valor_meta = ? WHERE id_meta = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sdi", $mes_meta, $valor_meta, $id);

        if ($stmt->execute()) {
            header("Location: listar.php");
            exit;
        } else {
            echo "<div style='color:red;'>Erro ao atualizar meta.</div>";
        }
    } else {
        echo "<div style='color:red;'>Preencha todos os campos corretamente.</div>";
    }
} else {
    $sql = "SELECT * FROM metas WHERE id_meta = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $meta = $resultado->fetch_assoc();

    if (!$meta) {
        echo "Meta não encontrada.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Meta</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f4f9f6;
    }

    .container {
        max-width: 600px;
        margin: 40px auto;
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    h1 {
        color: #337a5b;
        text-align: center;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .btn {
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-success {
        background-color: #4CAF50;
        color: white;
    }

    .btn-secondary {
        background-color: #ccc;
        color: black;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Editar Meta</h1>
        <form method="post">
            <label for="mes_meta">Mês da Meta:</label>
            <input type="text" name="mes_meta" class="form-control" value="<?= htmlspecialchars($meta['mes_meta']) ?>"
                required>

            <label for="valor_meta">Valor da Meta (R$):</label>
            <input type="number" step="0.01" name="valor_meta" class="form-control" value="<?= $meta['valor_meta'] ?>"
                required>

            <button type="submit" class="btn btn-success">Atualizar</button>
            <a href="listar.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>