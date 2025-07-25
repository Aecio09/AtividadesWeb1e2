<?php

require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $especialidade = $_POST['especialidade'];

    $stmt = $pdo -> prepare('INSERT INTO medico (nome, especialidade) VALUES (?,?)');
    $stmt -> execute([$nome, $especialidade]);
}

?>
<html>
    <body>
        <header>
            <link rel="stylesheet" href="css.css">
        <h1>
            ADCIONAR MEDICO
        </h1>
        <h3>
    <a href="index.php" class="voltar-btn">Voltar</a>
        </h3>
        </header>
        <main>
            <form method="post">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name = 'nome' required>

                <label for="nome">Especialidade</label>
                <input type="text" id ="especialidade" name = "especialidade" required>

                <button type="submit">Salvar</button>
            </form>
        </main>
    </body>
</html>