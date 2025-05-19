<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "healthbuddy";

$conn = "mysql:host=$host;dbname=$database";
$opc = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($conn, $user, $password, $opc);
} catch (PDOException $e) {
    die("Deu Ruim Corre puxa o PC da Tomada (Falha na conexão com o banco de dados): " . $e->getMessage());
}

?>