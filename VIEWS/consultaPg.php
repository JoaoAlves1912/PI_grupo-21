<?php
session_start();
if (empty($_SESSION['logado']) || $_SESSION['logado'] == false)
  header('location: ../index.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento de Consultas</title>
    <link rel="stylesheet" href="../CSS/styles5.css">
</head>
<body>
     <div class="container">
        <div class="menu-icon">
            <button onclick="location.href='profilePg.php'">←</button>
        </div>
    <div class="container">
        <div class="header">
            <h1>Agendar Consulta</h1>
        </div>
        
        <div class="content">
            <?php if (isset($_SESSION['sucesso'])): ?>
                <div class="alert success"><?= $_SESSION['sucesso']; unset($_SESSION['sucesso']); ?></div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['erro'])): ?>
                <div class="alert error"><?= $_SESSION['erro']; unset($_SESSION['erro']); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="../CONTROLLERS/consulta_controller.php">
                <div class="form-group">
                    <label for="data">Data:</label>
                    <input type="date" id="data" name="data" required>
                </div>
                
                <div class="form-group">
                    <label for="hora">Hora:</label>
                    <input type="time" id="hora" name="hora" required>
                </div>
                
                <div class="form-group">
                    <label for="medico">Médico:</label>
                    <input type="text" id="medico" name="medico" required>
                </div>
                
                <div class="form-group">
                    <label for="especialidade">Especialidade:</label>
                    <input type="text" id="especialidade" name="especialidade" required>
                </div>
                
                <div class="form-group">
                    <label for="historico">Histórico Resumido (opcional):</label>
                    <input type="text" id="historico" name="historico" required>
                </div>
                
                <button type="submit" name="agendar" class="button">Agendar Consulta</button>
            </form>
            
            <div class="consultas">
                <h2>Minhas Consultas</h2>
                <?php if (empty($_SESSION['consultas'])): ?>
                    <p>Nenhuma consulta agendada.</p>
                <?php else: ?>
                    <?php foreach ($_SESSION['consultas'] as $consulta): ?>
                        <div class="consulta">
                            <p><strong>Data:</strong> <?= date('d/m/Y', strtotime($consulta['data_consulta'])); ?></p>
                            <p><strong>Hora:</strong> <?= $consulta['hora_consulta']; ?></p>
                            <p><strong>Médico:</strong> <?= $consulta['medico']; ?></p>
                            <p><strong>Especialidade:</strong> <?= $consulta['especialidade']; ?></p>
                            <?php if (!empty($consulta['historico'])): ?>
                                <p><strong>Histórico:</strong> <?= $consulta['historico']; ?></p>
                            <?php endif; ?>
                            
                            <form class="remove-form" method="POST" action="../CONTROLLERS/cancelarcons_controller.php" style="margin-top: 10px;">
                                <input type="hidden" name="id_consulta" value="<?= $consulta['id']; ?>">
                                <button type="submit" name="cancelar" class="remove-btn">Cancelar Consulta</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>