<?php
require_once('../MODELS/conexao_db.php');
require_once('../MODELS/medicamento.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medicamento = $_POST['medicamento'];
    $hora = $_POST['hora'];
 
    $medicamento_model = new Medicamento($pdo);

    try {
        $medicamento_model->cadastrar($_SESSION['iduser'], $medicamento,$hora );
    } catch (Exception $e) {
        session_start();
        $_SESSION['erro'] = true;
        header('Location: ../VIEWS/registerPg.php');
        exit();
    }
} else {
    header('Location: ../VIEWS/error.php');
    exit();
}
