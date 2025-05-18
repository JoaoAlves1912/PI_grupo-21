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
    <title>Registrar</title>
       
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Health Buddy</h1>
        </div>
        <div class="content">
            <form action="../CONTROLLERS/register_controller.php" method="POST">
                <fieldset>
                    <legend>Registrar</legend>
                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" id="name" name="nome" placeholder="Digite seu nome" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
                    </div>
                    <div class="form-group">
                        <label for="idade">Idade</label>
                        <input type="number" id="idade" name="idade" placeholder="Digite sua idade" required>
                    </div>
                    <div class="form-group">
                        <label for="profissao">Profissão</label>
                        <input type="text" id="profissao" name="profissao" placeholder="Digite sua profissão" required>
                    </div>
                    <div class="form-group">
                        <label for="objetivo">Objetivo</label>
                        <input type="text" id="objetivo" name="objetivo" placeholder="Digite seu objetivo" required>
                    </div>
                    <div class="form-group">
                        <label for="saude">Condição de Saúde</label>
                        <input type="text" id="saude" name="saude" placeholder="Condição de saúde (opcional)">
                    </div>
                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" id="password" name="senha" placeholder="Digite sua senha" required>
                    </div>
                    <button class="button" type="submit">Registrar</button>
                </fieldset>
            </form>
            <div class="register-link">
                Já tem uma conta? <a href="loginPg.php">Entrar</a>
            </div>
        </div>
    </div>
</body>

</html>
