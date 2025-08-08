<?php
require_once 'banco/connect.php';

$stmtvendas = $pdo->query("SELECT * FROM venda");
$vendas = $stmtvendas->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['delete'])) {
    $id_venda = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM venda WHERE id_venda = ?");
    $stmt->execute([$id_venda]);
    header("Location: readEmodEdelet.php");
    exit();
}


?>

<h1>Vendas Registradas</h1>
<table border="1">
    <tr>
        <th>id venda</th>
        <th>id cliente</th>
        <th>id vendedor</th>
        <th>Valor</th>
        <th>Data</th>
    </tr>
    <?php foreach ($vendas as $venda): ?>
        <tr>
            <td><?= $venda['id_venda'] ?></td>
            <td><?= $venda['id_cliente'] ?></td>
            <td><?= $venda['id_vendedor'] ?></td>
            <td><?= number_format($venda['valor'], 2, ',', '.') ?></td>
            <td><?= date('d/m/Y', strtotime($venda['data'])) ?></td>
            <td>
                <a href="readEmodEdelet.php?delete=<?= $venda['id_venda'] ?>">Deletar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>