<?php
session_start();
// Verificar se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: loginPg.php");
    exit();
}

// Verificar se existem sintomas na sessão
$sintomas = isset($_SESSION['sintomas']) ? $_SESSION['sintomas'] : [];
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styles3.css">
    <title>Gerenciador de Sintomas</title>
    
</head>

<body>
    <div class="container">
    <div class="menu-icon">
            <button onclick="location.href='profilePg.php'">←</button>
        </div>
        <h1>Gestão de Sintomas</h1>
        <!-- Formulário de Entrada -->
        <form action="../CONTROLLERS/cadastrosin.php" method="post">
            <div class="form-group">
                <label for="sintoma">Nome do Sintoma:</label>
                <input type="text" id="sintoma" name="sintoma" placeholder="Exemplo: Dor de cabeça">
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" placeholder="Detalhe mais sobre o sintoma"></textarea>
            </div>
            <button class="button"  type="submit">Adicionar Sintoma</button>
        </form>

        <!-- Lista de Sintomas -->
        <div class="sintomas" id="listaSintomas">
            <h2>Histórico de Sintomas</h2>
            <!-- Sintomas serão adicionados dinamicamente -->
            <?php foreach ($sintomas as $sintoma): ?>
                <div class="sintoma">
                    <h3><?php echo htmlspecialchars($sintoma['sintoma']); ?></h3>
                    <p><?php echo htmlspecialchars($sintoma['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>