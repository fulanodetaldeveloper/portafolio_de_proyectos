<?php
ini_set('display_errors', 1); // Habilitar la visualización de errores
ini_set('display_startup_errors', 1);

$host = "127.0.0.1";
$db_name = "bd1";
$username = "toor";
$password = "1234";

try {
    $conn = new PDO(
        "mysql:host=" . $host . ";dbname=" . $db_name,
        $username,
        $password
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $conn->exec("SET NAMES utf8");
} catch(PDOException $e) {
    throw new Exception("Error de conexión: " . $e->getMessage());
}
echo "Connected successfully to MySQL as toor user";
?>
