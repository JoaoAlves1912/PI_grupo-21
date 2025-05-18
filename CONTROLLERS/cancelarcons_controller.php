<?php
session_start();
require_once('../MODELS/conexao_db.php');
require_once('../MODELS/Consulta.php');

// Verifica se é uma requisição POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../VIEWS/error.php');
    exit();
}

// Verifica se o usuário está logado
if (empty($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../index.php');
    exit();
}

try {
    if (empty($_POST['id_consulta'])) {
        throw new Exception('Consulta não identificada.');
    }

    $pdo = $GLOBALS['pdo'];
    $consulta_model = new Consulta($pdo);

    // Remove a consulta pelo ID e pelo usuário logado
    $consulta_model->cancelar($_POST['id_consulta']);


    $_SESSION['consultas'] = $consulta_model->listar($_SESSION['iduser']);
    $_SESSION['sucesso'] = 'Consulta cancelada com sucesso!';
} catch (Exception $e) {
    $_SESSION['erro'] = 'Erro ao cancelar: ' . $e->getMessage();
}

header('Location: ../VIEWS/consultaPg.php');
exit();
?>