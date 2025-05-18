<?php
require_once ('../MODELS/conexao_db.php');
require_once ('../MODELS/user.php');

$user_model = new User($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha_atual = $_POST['senha_atual'];
    $nova_senha = $_POST['nova_senha'];
    $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

    $user_model->alterarSenha($senha_atual, $senha_hash, $email);

} else {
    header("Location: ../VIEWS/error.php");
    exit();
}
?>