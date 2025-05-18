<?php
session_start();
if (empty($_SESSION['logado']) || $_SESSION['logado'] == false)
  header('location: ../index.php');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../CSS/styles2.css">
  <title>Configuração</title>
  
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>Health Buddy</h1>
      <div class="menu-icon">
        <button  onclick="location.href='profilePg.php'">←</button>
      </div>
    </div>
    <div class="content">
      <!-- Informações do Usuário -->
      <div class="user-info">
        <div class="user-icon">👤</div>
        <h2> <?php echo $_SESSION['name']; ?></h2>
      </div>
     

      <!-- Botões de Navegação -->
      <button class="button" onclick="location.href='edit_passwordPg.php'">Alterar senha</button>
      <form action="../CONTROLLERS/logout_controller.php" method="POST" style="display: inline;">
        <input type="hidden" name="logout" value="true">
        <button class="button" type="submit" onclick="return confirm('Tem certeza que deseja sair?')">Sair</button>
      </form>
     

    </div>
  </div>
</body>

</html>