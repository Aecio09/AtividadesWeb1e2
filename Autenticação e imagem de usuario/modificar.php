<?php 
require_once 'connect.php';

if (!isset($_GET['id_consulta'])) {
    echo "Consulta não encontrada.";
    exit;
}

$id_consulta = $_GET['id_consulta'];


$stmt = $pdo->prepare('SELECT * FROM consulta WHERE id_consulta = ?');
$stmt->execute([$id_consulta]);
$consulta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$consulta) {
    echo "Consulta não encontrada.";
    exit;
}


$medicos = $pdo->query('SELECT id_medico, nome FROM medico')->fetchAll(PDO::FETCH_ASSOC);
$pacientes = $pdo->query('SELECT id_paciente, nome FROM paciente')->fetchAll(PDO::FETCH_ASSOC);

// Atualiza consulta se enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data_hora = $_POST['data_hora'];
    $observacao = $_POST['observacao'];
    $descricao = $_POST['descricao'];
    $id_medico = $_POST['id_medico'];
    $id_paciente = $_POST['id_paciente'];

    $stmt = $pdo->prepare('UPDATE consulta SET data_hora=?, observacao=?, descricao=?, id_medico=?, id_paciente=? WHERE id_consulta=?');
    $stmt->execute([$data_hora, $observacao, $descricao, $id_medico, $id_paciente, $id_consulta]);
    header('Location: consulta.php');
    exit;
}
?>
<html>
    <link rel="stylesheet" href="css.css">
<body>
    <h1>Editar Consulta</h1>
    <form method="post">
        <label>Data e Hora</label>
        <input type="datetime-local" name="data_hora" value="<?= date('Y-m-d\TH:i', strtotime($consulta['data_hora'])) ?>" required><br>

        <label>Observação</label>
        <input type="text" name="observacao" value="<?= htmlspecialchars($consulta['observacao']) ?>" required><br>

        <label>Descrição</label>
        <input type="text" name="descricao" value="<?= htmlspecialchars($consulta['descricao']) ?>" required><br>

        <label>Médico</label>
        <select name="id_medico" required>
            <?php foreach ($medicos as $medico): ?>
                <option value="<?= $medico['id_medico'] ?>" <?= $medico['id_medico'] == $consulta['id_medico'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($medico['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Paciente</label>
        <select name="id_paciente" required>
            <?php foreach ($pacientes as $paciente): ?>
                <option value="<?= $paciente['id_paciente'] ?>" <?= $paciente['id_paciente'] == $consulta['id_paciente'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($paciente['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <button type="submit">Salvar Alterações</button>
        <a href="consulta.php">Cancelar</a>
    </form>
</body>
</html>

