<?php

require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $tipo_sanguineo = $_POST['tipo_sanguineo'];

    $stmt = $pdo -> prepare('INSERT INTO paciente (nome, tipo_sanguineo) VALUES (?, ?)');
    $stmt -> execute([$nome, $tipo_sanguineo]);
}

?>
<html>
    <body>
        <header>
            <link rel="stylesheet" href="css.css">
        <h1>
            ADCIONAR PACIENTES
        </h1>
        <h3>
    <a href="index.php" class="voltar-btn">Voltar</a>
        </h3>
        </header>
        <main>
            <form method="post">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name = 'nome' required>

                <label for="tipo_sanguineo">Tipo Sanguíneo</label>
                <input type="text" id="tipo_sanguineo" name='tipo_sanguineo' required>

                <button type="submit">Salvar</button>
            </form>
        </main>
    </body>
</html>