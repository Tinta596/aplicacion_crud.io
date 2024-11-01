<?php
// db_connection.php

$host = 'localhost;port=3307'; // Cambia el puerto si es necesario
$dbname = 'crud_app'; // Nombre de tu base de datos
$username = 'root'; // Tu usuario de MySQL
$password = ''; // Tu contraseña de MySQL


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
    exit;
}
?>
