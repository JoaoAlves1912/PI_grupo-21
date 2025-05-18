<?php
session_start();
// Verificar se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: loginPg.php");
    exit();
}

// Verificar se existem medicamentos na sessão
$medicamentos = isset($_SESSION['medicamentos']) ? $_SESSION['medicamentos'] : [];
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styles3.css">
    <title>Gerenciador de Medicamentos</title>
   
</head>

<body>
    <div class="container">
        <div class="menu-icon">
            <button onclick="location.href='profilePg.php'">←</button>
        </div>
        <h1>Medicamentos</h1>
        <!-- Formulário de Entrada -->
        <form action="../CONTROLLERS/cadastromed.php" method="post">
            <div class="form-group">
                <label for="medicamento">Nome do Medicamento:</label>
                <input type="text" id="medicamento" name="medicamento" placeholder="Exemplo: Dipirona">
            </div>
            <div class="form-group">
                <label for="horario">Horário:</label>
                <input type="time" id="hora" name="hora" placeholder="Exemplo: Dor de cabeça">
            </div>
            <button class="button" type="submit">Adicionar Medicamento</button>
        </form>

        <!-- Lista de Sintomas -->
        <div class="sintomas" id="listaSintomas">
            <h2>Horário Medicamentos</h2>
            <!-- Sintomas serão adicionados dinamicamente -->
            <?php foreach ($medicamentos as $medicamento): ?>
                <form action="../CONTROLLERS/removermed.php" method="post">
                    <div class="medicamento">
                        <h3><?php echo htmlspecialchars($medicamento['name']); ?></h3>
                        <p><?php echo htmlspecialchars(date('H:i', strtotime($medicamento['hora']))); ?></p>

                        <input type="hidden" id="id" name="id" value="<?php echo $medicamento['id']; ?>">
                        <button class="remove-btn" type="submit">Remover Medicamento</button>

                    </div>
                </form>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>
