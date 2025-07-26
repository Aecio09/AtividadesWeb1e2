<?php
require_once 'connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE nome = ?");
    $stmt->execute([$nome]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id_usuario'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        header("Location: index.php");
        exit();
    } else {
        $erro = "Nome de usuário ou senha incorretos.";
    }
}
?>
<!doctype html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css.css">
</head>
<body>
<header>
    <h1>Login</h1>
</header>
<form method="POST">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required>
    <br>
    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" required>
    <br>
    <button type="submit">Entrar</button>
</html>
