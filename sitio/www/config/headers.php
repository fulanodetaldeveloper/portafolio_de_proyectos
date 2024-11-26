<?php
// Configurar las cabeceras para manejar JSON
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$method = strtoupper(str_replace(' ', '', trim($_SERVER['REQUEST_METHOD'])));

?>
