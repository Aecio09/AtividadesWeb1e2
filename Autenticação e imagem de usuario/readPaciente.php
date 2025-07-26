<?php
require_once 'connect.php';

$stmt = $pdo->prepare('SELECT p.id_paciente, p.nome, p.tipo_sanguineo, i.path AS imagem_path FROM paciente p LEFT JOIN imagem i ON p.Imagem_id = i.id_imagem');
$stmt->execute();
$pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html> 
<head>
    <meta charset="UTF-8">
    <title>Lista de Pacientes</title>
    <link rel="stylesheet" href="css.css">
</head>
<body>
<header>
    <h1>LISTA DE PACIENTES</h1>
    <h3><a href="add.php" class="adicionar-btn">Adicionar Paciente</a></h3>
    <h3><a href="index.php" class="voltar-btn">Voltar</a></h3>
</header>
<main>
    <table>
        <thead>
            <tr>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Tipo Sanguíneo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pacientes as $paciente): ?>
                <tr>
                    <td>
                        <img src="<?php echo htmlspecialchars($paciente['imagem_path'] ?? 'assets/profile_jpg.jpg'); ?>" alt="Imagem do Paciente" class="paciente-imagem">
                    </td>
                    <td><?php echo htmlspecialchars($paciente['nome']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['tipo_sanguineo']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
</body>
</html>
