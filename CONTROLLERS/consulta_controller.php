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
    $pdo = $GLOBALS['pdo']; // Garante que $pdo está disponível
    $consulta_model = new Consulta($pdo);

    // Verificação dos campos obrigatórios
    $camposObrigatorios = [
        'data' => 'Data é obrigatória',
        'hora' => 'Hora é obrigatória',
        'medico' => 'Médico é obrigatório',
        'especialidade' => 'Especialidade é obrigatória'
    ];

    foreach ($camposObrigatorios as $campo => $mensagem) {
        if (empty($_POST[$campo])) {
            throw new Exception($mensagem);
        }
    }

    // Agendamento da consulta
    $consulta_model->agendar(
        $_SESSION['iduser'],
        $_POST['data'],
        $_POST['hora'],
        $_POST['medico'],
        $_POST['especialidade'],
        $_POST['historico'] ?? ''
    );
    
    $_SESSION['consultas'] = $consulta_model->listar($_SESSION['iduser']);
    $_SESSION['sucesso'] = 'Consulta agendada com sucesso!';
} catch (Exception $e) {
    $_SESSION['erro'] = 'Erro ao agendar: ' . $e->getMessage();
}

header('Location: ../VIEWS/consultaPg.php');
exit();
?>