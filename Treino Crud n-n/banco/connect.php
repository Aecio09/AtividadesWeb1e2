<?php

$host = 'localhost:3306';
$db = 'BANCO_TRISTE';
$user = 'root';
$password = 'root';


try {
    $pdo = new pdo("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>