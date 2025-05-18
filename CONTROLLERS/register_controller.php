<?php
require_once('../MODELS/conexao_db.php');
require_once('../MODELS/user.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $idade = $_POST['idade'];
    $profissao = $_POST['profissao'];
    $objetivo = $_POST['objetivo'];
    $saude = $_POST['saude'];
    $senha = $_POST['senha'];
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $user_model = new User($pdo);

    try {
        $user_model->criarCompleto($nome, $email, $senha_hash, $idade, $profissao, $objetivo, $saude);
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
