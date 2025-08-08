<?php   

require_once 'banco/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    
    $stmt = $pdo ->prepare(('INSERT INTO cliente (nome) VALUES (?)'));
    $stmt->execute([$nome]);
}

?>

<h1>Cadastro de Cliente</h1>

<form method = 'POST'>
    <label for="nome">Nome</label>
    <input type="text" name="nome" id="nome" required>
    <button type="submit">Cadastrar</button>
</form>