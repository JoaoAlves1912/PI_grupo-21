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
    <link rel="stylesheet" href="../CSS/styles.css">
    <title>Redefinição Senha</title>

</head>

<body>
    <div class="container">
        <div class="header">
        <div class="menu-icon">
            <button onclick="location.href='profilePg.php'">←</button>
        </div>
            <h1>Health Buddy</h1>
        </div>
        <div class="content">
            <form action="../CONTROLLERS/edit_password_controller.php" method="POST">
                <p>
                    <?php
                    if (!empty($_SESSION['erro'])): ?>
                        <?php if ($_SESSION['erro']): ?>
                        <div class="warning">
                            Senha Atual Incorreta
                        </div>
                    <?php endif ?>
                    <?php $_SESSION['erro'] = false; endif ?>
                </p>
                <fieldset>
                    <legend>Alterar Senha</legend>
                    <div class="form-group">
                        <input type="password" id="password" name="senha_atual" placeholder="Digite sua senha atual" required>
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" name="nova_senha" placeholder="Digite uma nova senha" required>
                    </div>
                    <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>">
                    <button class="button" type="submit">Alterar senha</button>
                </fieldset>
            </form>
        </div>
    </div>
</body>

</html>