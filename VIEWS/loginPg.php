<?php
session_start();
if (!empty($_SESSION['logado'])) {
    header('location: ../index.php');
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styles.css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Health Buddy</h1>
        </div>
        <div class="content">
            <form action="../CONTROLLERS/login_controller.php" method="POST">
                <p>
                    <?php
                    if (!empty($_SESSION['erro'])): ?>
                        <?php if ($_SESSION['erro']): ?>
                        <div class="warning">
                            Usuario ou senha invalidos.
                        </div>
                    <?php endif ?>
                    <?php $_SESSION['erro'] = false; endif ?>
                </p>
                <fieldset>
                    <legend>Entrar</legend>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
                    </div>
                    <button class="button" type="submit">Entrar</button>
                </fieldset>
            </form>
            <div class="register-link">
                Não tem uma conta? <a href="registerPg.php">Cadastre-se</a>
            </div>
        </div>
    </div>
</body>

</html>