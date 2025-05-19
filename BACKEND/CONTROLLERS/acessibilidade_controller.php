<?php
session_start();
require_once('../MODELS/conexao_db.php');
require_once('../MODELS/acessibilidade.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../FRONTEND/VIEWS/error.php");
    exit();
}

try {
    global $pdo;
    $model = new Acessibilidade($pdo);
    
    $altoContraste = isset($_POST['alto_contraste']) ? 1 : 0;
    $tamanhoFonte = $_POST['tamanho_fonte'] ?? 'normal';
    $leitorTela = isset($_POST['leitor_tela']) ? 1 : 0;
    
    $model->salvarPreferencias($_SESSION['iduser'], $altoContraste, $tamanhoFonte, $leitorTela);
    
    $_SESSION['sucesso'] = "Preferências atualizadas com sucesso!";
} catch (Exception $e) {
    $_SESSION['erro'] = "Erro ao salvar: " . $e->getMessage();
}

header("Location: ../../FRONTEND/VIEWS/acessibilidadePg.php");
exit();
?>