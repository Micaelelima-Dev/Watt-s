<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    // Usuário não está logado, redireciona para login
    header("Location: login.php");
    exit();
}
?>