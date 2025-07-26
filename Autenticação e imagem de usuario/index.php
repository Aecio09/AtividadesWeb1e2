<?php
session_start();
?>

<h1>
    Bem vindo
</h1>
<link rel="stylesheet" href="css.css">


<?php if (isset($_SESSION['usuario_nome'])): ?>
<a href="add.php">adcionar paciente</a>
<br>
<a href="add2.php">adcionar medico</a>
<br>
<a href="consulta.php">Criar consulta</a>
<br>
<a href="readPaciente.php">Lista de Pacientes</a>
<br>
<a href="logout.php">Sair</a>
<?php else: ?>
<a href="registro.php">Registrar</a>
<a href="login.php">Entrar</a>
<?php endif; ?>


