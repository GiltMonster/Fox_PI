<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h2>Login do Administrador</h2>

    <form action="../../php/login/processa_login.php" method="post">
        <label for="adm_email">E-mail:</label>
        <input type="email" id="adm_email" name="adm_email" required>
        <p></p>
        <label for="adm_senha">Senha</label>
        <input type="password" id="adm_senha" name="adm_senha" required>
        <p></p>

        <input type="submit" value="Entrar">

        <?php
        if (isset($_GET['erro'])) { //se existir o parâmetro erro na URL
            echo '<p style="color:red;">Nome de usuário ou senha incorretos!</p>';
        }
        ?>
    </form>
</body>

</html>