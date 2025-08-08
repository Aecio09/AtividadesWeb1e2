<?php   
require_once 'banco/connect.php';

$stmtclientes = $pdo->query("SELECT id_cliente, nome FROM cliente");
$clientes = $stmtclientes->fetchAll(PDO::FETCH_ASSOC);

$stmtvendedores = $pdo->query("SELECT id_vendedor, nome FROM vendedor");
$vendedores = $stmtvendedores->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $id_vendedor = $_POST['id_vendedor'];
    $valor = $_POST['valor'];
    $data = $_POST['data'];

    $stmt = $pdo->prepare("INSERT INTO venda (id_cliente, id_vendedor, valor, data) VALUES (?, ?, ?, ?)");
    $stmt->execute([$id_cliente, $id_vendedor, $valor, $data]);    
}

?>

<h1>Cadastro de Venda</h1>
<form method="post">

    <label for="id_cliente">ID Cliente</label>
    <select id="id_cliente" name="id_cliente" required>
    <option value="">Escolha</option>
    <?php foreach ($clientes as $cliente): ?>
        <option value="<?= $cliente['id_cliente'] ?>"><?= $cliente['nome'] ?></option>
    <?php endforeach; ?>
    </select>

    <label for="id_vendedor">ID Vendedor</label>
    <select id="id_vendedor" name="id_vendedor" required>
    <option value="">Escolha</option>
    <?php foreach ($vendedores as $vendedor): ?>
    <option value="<?= $vendedor['id_vendedor'] ?>"><?= $vendedor['nome'] ?></option>
    <?php endforeach; ?>
    </select>
    
    <label for="valor">Valor</label>
    <input type="text" id="valor" name="valor" required>
    
    <label for="data">Data</label>
    <input type="date" id="data" name="data" required>
    
    <button type="submit">Cadastrar</button>
</form>