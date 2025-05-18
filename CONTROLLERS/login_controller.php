<?php
require_once ('../MODELS/conexao_db.php');
require_once ('../MODELS/user.php');

$user_model = new User($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $senha = $_POST['password'];

    $user_model->fazerLogin($email, $senha);
} else {
    header("Location: ../VIEWS/error.php");
    exit();
}
?>