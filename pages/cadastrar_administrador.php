<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Administrador</title>
    <link rel="stylesheet" href="../style/index.css">
</head>

<body>
    <header class="navbar">
        <h1>Fox brinquedos</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="./painel_admin.php">Administradores</a></li>
                <li><a href="./painel_produtos.php">Produtos</a></li>
            </ul>
        </nav>
    </header>

    <h2>Cadastro de Administrador</h2>
    <form action="../php/admin.php" method="post" enctype="multipart/form-data">
        <label for="adm_nome">Nome do administrador: </label>
        <input type="text" id="adm_nome" name="adm_nome" required>
        <p></p>
        <label for="adm_email">E-mail Administrador: </label>
        <input type="text" id="adm_email" name="adm_email" required>
        <p></p>
        <label for="adm_senha">Senha administrador: </label>
        <input type="password" minlenght="8" id="adm_senha" name="adm_senha" required>
        <p></p>
        <label for="adm_ativo">Ativo:</label>
        <input type="checkbox" name="adm_ativo" id="adm_ativo" value="1" checked>
        <p></p>
        <input type="submit" value="Cadastrar">
    </form>

</body>

</html>