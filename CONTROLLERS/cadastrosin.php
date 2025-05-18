<?php
require_once('../MODELS/conexao_db.php');
require_once('../MODELS/sintoma.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sintoma = $_POST['sintoma'];
    $descricao = $_POST['descricao'];
 
    $sintoma_model = new Sintoma($pdo);

    try {
        $sintoma_model->cadastrar($_SESSION['iduser'], $sintoma,$descricao );
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
