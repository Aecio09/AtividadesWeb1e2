<?php
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("select * from usuario where nome = ?");
    $stmt->execute([$nome]);
    if($stmt->rowCount() > 0) {
        echo "Usuário já existe.";
    } else {
        $stmt = $pdo->prepare("insert into usuario (nome, senha) values (?, ?)");
        if ($stmt->execute([$nome, $senha])) {
            echo "Usuário cadastrado com sucesso.";
                usleep(500000);
                header("Location: login.php");
                exit;
        } else {
            echo "Erro ao cadastrar usuário.";
        }
    }
}
    ?>

    <!doctype html>
    <html>
    <head>
        <title>Registro de Usuário</title>
        <link rel="stylesheet" href="css.css">
    </head>
    <body>
        <header>
    <h1>Registro de Usuário</h1>
    </header>

    <form method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        <br>
        <button type="submit">Registrar</button>
    </form>
    </body> 
    </html>