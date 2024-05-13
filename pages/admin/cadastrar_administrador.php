<?php

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../login/login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Administrador</title>
    <link rel="stylesheet" href="../../style/index.css">
    <link rel="stylesheet" href="../../style/admin/cadastro_admin.css">
</head>

<body>
    <header class="navbar">
        <div>

            <img src="../../images/fox.svg" alt="fox logo" />
            <nav>
                <ul>
                    <li><a href="../../index.php">Home</a></li>
                    <li><a href="./painel_admin.php">Administradores</a></li>
                    <li><a href="../produto/painel_produtos.php">Produtos</a></li>
                </ul>
            </nav>
        </div>
        <a class="btn-sair" href="./cadastrar_administrador.php?logout">Sair</a>
    </header>
    <main>
        <section class="container">
            <div class="sub-header">
                <h2>Cadastrar novo administrador</h2>
            </div>
            <div class="container-form">
                <form action="../../php/admin/cadastra_admin.php" method="post" enctype="multipart/form-data">
                    <div class="campos">
                        <label for="adm_nome">Nome</label>
                        <input type="text" id="adm_nome" name="adm_nome" required>
                    </div>

                    <div class="campos">
                        <label for="adm_email">E-mail</label>
                        <input type="text" id="adm_email" name="adm_email" required>
                    </div>
                    <div class="campos">
                        <label for="adm_senha">Senha</label>
                        <input type="password" minlenght="8" id="adm_senha" name="adm_senha" required>
                    </div>

                    <div class="campos">
                        <label for="adm_ativo">Ativo</label>
                        <input type="checkbox" name="adm_ativo" id="adm_ativo" value="1">
                        <label for="adm_ativo" id="txt_adm_ativo">Ativo</label>
                    </div>
                    <div class="btn-group">
                        <input class="btn-salvar" type="submit" value="Salvar" />
                        <a class="btn-cancelar" href="./painel_admin.php">Cancelar</a>
                    </div>
                </form>
            </div>

        </section>
    </main>

</body>

</html>