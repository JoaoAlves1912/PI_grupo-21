<?php
session_start();
if (empty($_SESSION['logado']) || $_SESSION['logado'] == false) {
    header('location: ../index.php');
    exit();
}

// 1. Inclua o arquivo de conexão primeiro
require_once('../MODELS/conexao_db.php');
// 2. Depois inclua o modelo
require_once('../MODELS/acessibilidade.php');

// 3. Certifique-se que $pdo está disponível
global $pdo;
$acessibilidade_model = new Acessibilidade($pdo);

try {
    $preferencias = $acessibilidade_model->carregarPreferencias($_SESSION['iduser']);
    
    $altoContraste = $preferencias['alto_contraste'] ?? false;
    $tamanhoFonte = $preferencias['tamanho_fonte'] ?? 'normal';
    $leitorTela = $preferencias['leitor_tela'] ?? false;

    $bodyClass = '';
    if ($altoContraste) $bodyClass .= ' high-contrast';
    if ($tamanhoFonte === 'grande') {
        $bodyClass .= ' large-text';
    } elseif ($tamanhoFonte === 'extra-grande') {
        $bodyClass .= ' xlarge-text';
    }
} catch (Exception $e) {
    $_SESSION['erro'] = "Erro ao carregar preferências: " . $e->getMessage();
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações de Acessibilidade</title>
    <link rel="stylesheet" href="../CSS/styles5.css">
    <?php if ($leitorTela): ?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../JS/leitorTela.js"></script>
    <?php endif; ?>
</head>
<!-- Restante do código permanece igual -->
<body class="<?= $bodyClass; ?>">
    <div class="container">
        <div class="menu-icon">
        <button  onclick="location.href='profilePg.php'">←</button>
      </div>
        <div class="header">
            <h1>Configurações de Acessibilidade</h1>
        </div>
        
        <div class="content">
            <?php if (isset($_SESSION['sucesso'])): ?>
                <div class="alert success"><?= $_SESSION['sucesso']; unset($_SESSION['sucesso']); ?></div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['erro'])): ?>
                <div class="alert error"><?= $_SESSION['erro']; unset($_SESSION['erro']); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="../CONTROLLERS/acessibilidade_controller.php">
                <div class="form-group checkbox">
                    <input type="checkbox" id="alto_contraste" name="alto_contraste" 
                           <?= ($altoContraste) ? 'checked' : ''; ?>>
                    <label for="alto_contraste">Modo Alto Contraste</label>
                </div>
                
                <div class="form-group">
                    <label for="tamanho_fonte">Tamanho da Fonte:</label>
                    <select id="tamanho_fonte" name="tamanho_fonte">
                        <option value="normal" <?= ($tamanhoFonte === 'normal') ? 'selected' : ''; ?>>Normal</option>
                        <option value="grande" <?= ($tamanhoFonte === 'grande') ? 'selected' : ''; ?>>Grande</option>
                        <option value="extra-grande" <?= ($tamanhoFonte === 'extra-grande') ? 'selected' : ''; ?>>Extra Grande</option>
                    </select>
                </div>
                
                <div class="form-group checkbox">
                    <input type="checkbox" id="leitor_tela" name="leitor_tela" 
                           <?= ($leitorTela) ? 'checked' : ''; ?>>
                    <label for="leitor_tela">Ativar Leitor de Tela</label>
                </div>
                
                <button type="submit" class="button">Salvar Configurações</button>
            </form>
            
            <div class="accessibility-tools">
                <h2>Ferramentas Rápidas</h2>
                <button id="toggle-contrast" class="button small">Alternar Contraste</button>
                <button id="increase-font" class="button small">Aumentar Fonte</button>
                <button id="decrease-font" class="button small">Diminuir Fonte</button>
                <button id="read-page" class="button small">Ler Página</button>
            </div>
        </div>
    </div>
    
    <script>
        // Ferramentas rápidas de acessibilidade
        document.getElementById('toggle-contrast').addEventListener('click', function() {
            document.body.classList.toggle('high-contrast');
        });
        
        document.getElementById('increase-font').addEventListener('click', function() {
            const body = document.body;
            if (body.classList.contains('xlarge-text')) return;
            if (body.classList.contains('large-text')) {
                body.classList.remove('large-text');
                body.classList.add('xlarge-text');
            } else {
                body.classList.add('large-text');
            }
        });
        
        document.getElementById('decrease-font').addEventListener('click', function() {
            const body = document.body;
            if (body.classList.contains('xlarge-text')) {
                body.classList.remove('xlarge-text');
                body.classList.add('large-text');
            } else if (body.classList.contains('large-text')) {
                body.classList.remove('large-text');
            }
        });
        
        document.getElementById('read-page').addEventListener('click', function() {
            // Implementação básica - em produção use uma biblioteca como Speak.js
            alert('Leitor de tela ativado. Em produção, esta função usaria uma biblioteca de síntese de voz.');
        });
    </script>
</body>
</html>