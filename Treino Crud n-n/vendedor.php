<?php   

require_once 'banco/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];

    $stmt = $pdo->prepare("INSERT INTO vendedor (nome) VALUES (?)");
    $stmt->execute([$nome]);    
}

?>

<h1>Cadastro de Vendedor</h1>
<form method="post">
    <label for="nome">Nome</label>
    <input type="text" id="nome" name="nome" required>
    <button type="submit">Cadastrar</button>
</form>