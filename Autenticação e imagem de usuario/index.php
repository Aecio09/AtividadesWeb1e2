<?php
session_start();
?>

<h1>
    Bem vindo
</h1>
<link rel="stylesheet" href="css.css">


<?php if (isset($_SESSION['usuario_nome'])): ?>
<a href="add.php">adcionar paciente</a>
<h1></h1>
<a href="add2.php">adcionar medico</a>
<br>
<h1></h1>
<a href="consulta.php">Criar consulta</a>
<br>
<h1></h1>
<a href="readPaciente.php">Lista de Pacientes</a>
<br>
<h1></h1>
<a href="logout.php">Sair</a>
<?php else: ?>
<a href="registro.php">Registrar</a>
<br>
<h1></h1>
<br>
<a href="login.php">Entrar</a>
<?php endif; ?>


