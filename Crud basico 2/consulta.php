<?php

require_once 'connect.php';

// Processa exclusão
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare('DELETE FROM consulta WHERE id_consulta = ?');
    $stmt->execute([$id]);
    header('Location: consulta.php');
    exit;
}

$stmtMedicos = $pdo->query('SELECT id_medico, nome FROM medico');
$medicos = $stmtMedicos->fetchAll(PDO::FETCH_ASSOC);


$stmtPacientes = $pdo->query('SELECT id_paciente, nome FROM paciente');
$pacientes = $stmtPacientes->fetchAll(PDO::FETCH_ASSOC);

$stmtConsultas = $pdo->query('
    SELECT c.id_consulta, c.data_hora, c.observacao, c.descricao, 
     m.nome AS medico, p.nome AS paciente
    FROM consulta c
    JOIN medico m ON c.id_medico = m.id_medico
    JOIN paciente p ON c.id_paciente = p.id_paciente
    ORDER BY c.data_hora DESC
');
$consultas = $stmtConsultas->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data_hora = $_POST['data_hora'];
    $observacao = $_POST['observacao'];
    $descricao = $_POST['descricao'];
    $id_medico = $_POST['id_medico'];
    $id_paciente = $_POST['id_paciente'];
    

    $stmt = $pdo -> prepare('INSERT INTO consulta (data_hora, observacao, descricao, id_paciente, id_medico) VALUES (?,?, ?, ?, ?)');
    $stmt -> execute([$data_hora, $observacao, $descricao, $id_paciente, $id_medico]);
}

?>
<html>
    <body>
        <header>
        <link rel="stylesheet" href="css.css">
        <h1>
            Registrar Consulta
        </h1>
        <h3>Lista de Consultas</h3>
        <table border="1">
            <tr>
                <th>Data/Hora</th>
                <th>Médico</th>
                <th>Paciente</th>
                <th>Observação</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($consultas as $consulta): ?>
            <tr>
                <td><?= htmlspecialchars($consulta['data_hora']) ?></td>
                <td><?= htmlspecialchars($consulta['medico']) ?></td>
                <td><?= htmlspecialchars($consulta['paciente']) ?></td>
                <td><?= htmlspecialchars($consulta['observacao']) ?></td>
                <td><?= htmlspecialchars($consulta['descricao']) ?></td>
                <td>
                    <a href="modificar.php?id_consulta=<?= $consulta['id_consulta'] ?>">Editar</a>
                    <a href="consulta.php?delete=<?= $consulta['id_consulta'] ?>" class="excluir-btn" onclick="return confirm('Tem certeza que deseja excluir esta consulta?');">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <h3>
    <a href="index.php" class="voltar-btn">Voltar</a>
        </h3>
        </header>
        <main>
    <form method="post" class="form-consulta">
        <label for="data_hora">Data e Hora</label>
        <input type="datetime-local" id="data_hora" name='data_hora' required>

        <label for="observacao">Observação</label>
        <input type="text" id="observacao" name='observacao' required>

        <label for="descricao">Descrição</label>
        <input type="text" id="descricao" name='descricao' required>

        <label for="id_medico">Médico</label>
        <select name="id_medico" required>
            <option value="">Escolha um médico</option>
            <?php foreach ($medicos as $medico): ?>
        <option value="<?= $medico['id_medico'] ?>"><?= $medico['nome'] ?></option>
    <?php endforeach; ?>
        </select>

        <label for="id_paciente">Paciente</label>
        <select name="id_paciente" required>
            <option value="">Escolha um paciente</option>
            <?php foreach ($pacientes as $paciente): ?>
        <option value="<?= $paciente['id_paciente'] ?>"><?= $paciente['nome'] ?></option>
    <?php endforeach; ?>
        </select>

        <button type="submit">Salvar</button>
    </form>
</main>
    </body>
</html>