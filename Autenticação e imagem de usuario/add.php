<?php
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $tipo_sanguineo = $_POST['tipo_sanguineo'];
    $id_imagem = null;

    if (!empty($_FILES['imagem']['name'])) {
        if ($_FILES['imagem']['error'] !== UPLOAD_ERR_OK) {
            exit;
        }

        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $nome_imagem = uniqid() . '.' . $extensao;
        $caminho_imagem = 'assets/' . $nome_imagem;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_imagem)) {
            $stmt = $pdo->prepare("INSERT INTO imagem (path) VALUES (?)");
            $stmt->execute([$caminho_imagem]);
            $id_imagem = $pdo->lastInsertId();
        } else {
            echo "Erro ao mover a imagem para a pasta 'assets'.<br>";
            exit;
        }
    }

    $stmt = $pdo->prepare('INSERT INTO paciente (nome, tipo_sanguineo, Imagem_id) VALUES (?, ?, ?)');
    $stmt->execute([$nome, $tipo_sanguineo, $id_imagem]);

    echo "Paciente cadastrado com sucesso.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Adicionar Pacientes</title>
    <link rel="stylesheet" href="css.css">
</head>
<body>
    <header>
        <h1>ADICIONAR PACIENTES</h1>
        <h3><a href="index.php" class="voltar-btn">Voltar</a></h3>
    </header>
    <main>
        <form method="post" enctype="multipart/form-data">
            <label for="imagem">Imagem</label>
            <input type="file" id="imagem" name="imagem" accept="image/*" required>

            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" required>

            <label for="tipo_sanguineo">Tipo Sanguíneo</label>
            <input type="text" id="tipo_sanguineo" name="tipo_sanguineo" required>

            <button type="submit">Salvar</button>
        </form>
    </main>
</body>
</html>