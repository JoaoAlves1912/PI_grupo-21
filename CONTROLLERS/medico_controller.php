<?php
require_once('../MODELS/conexao_db.php');
require_once('../MODELS/medico.php');

session_start();

// Verificar se o usuário está logado
if (empty($_SESSION['logado']) || $_SESSION['logado'] == false) {
    header('HTTP/1.1 401 Unauthorized');
    exit(json_encode(['error' => 'Acesso não autorizado']));
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $medico_model = new Medico($pdo);
    
    // Busca por especialidade
    if (isset($_GET['especialidade'])) {
        $especialidade = filter_input(INPUT_GET, 'especialidade', FILTER_SANITIZE_STRING);
        
        if (empty($especialidade)) {
            header('HTTP/1.1 400 Bad Request');
            exit(json_encode(['error' => 'Especialidade não fornecida']));
        }
        
        try {
            $medicos = $medico_model->buscarPorEspecialidade($especialidade);
            header('Content-Type: application/json');
            echo json_encode($medicos);
            exit();
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            exit(json_encode(['error' => 'Erro ao buscar médicos']));
        }
    }
    
    // Listar todas especialidades
    if (isset($_GET['listar_especialidades'])) {
        try {
            $especialidades = $medico_model->buscarTodasEspecialidades();
            header('Content-Type: application/json');
            echo json_encode($especialidades);
            exit();
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            exit(json_encode(['error' => 'Erro ao buscar especialidades']));
        }
    }
}

header('HTTP/1.1 400 Bad Request');
exit(json_encode(['error' => 'Requisição inválida']));
?>