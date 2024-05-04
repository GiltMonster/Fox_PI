<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Administrador</title>
    <link rel="stylesheet" href="../../style/index.css">
    <link rel="stylesheet" href="../../style/admin/cadastro_admin.css">
</head>

<body>

    <?php
    require_once '../../php/config/conexao.php';
    include '../../php/admin/editar_admin.php';
    ?>

    <header class="navbar">
        <img src="../../images/fox.svg" alt="fox logo" />
        <nav>
            <ul>
                <li><a href="../../index.php">Home</a></li>
                <li><a href="./painel_admin.php">Administradores</a></li>
                <li><a href="../produto/painel_produtos.php">Produtos</a></li>
            </ul>
        </nav>

        <button class="btn-sair">Sair</button>
    </header>

    <main>
        <section class="container">

            <div class="cadastro-header">
                <h2>Editar administrador</h2>
            </div>

            <div class="container-form">
                <form method="POST" enctype="multipart/form-data">
                    <div class="campos">
                        <input type='hidden' id="adm_id" name='adm_id' value="<?php echo $administrador['ADM_ID']; ?>" />
                        <label for="adm_nome">Nome</label>
                        <input type="text" id="adm_nome" name="adm_nome" value="<?php echo $administrador['ADM_NOME']; ?>" required>
                    </div>

                    <div class="campos">
                        <label for="adm_email">E-mail</label>
                        <input type="text" id="adm_email" name="adm_email" value="<?php echo $administrador['ADM_EMAIL']; ?>" required>
                    </div>
                    <div class="campos">
                        <label for="adm_senha">Senha</label>
                        <input type="password" minlenght="8" id="adm_senha" name="adm_senha" value="<?php echo $administrador['ADM_SENHA']; ?>" required>
                    </div>
                    <div class="campos">
                        <label for="adm_ativo">Ativo</label>
                        <input type="checkbox" name="adm_ativo" id="adm_ativo" value="1" <?php echo $administrador['ADM_ATIVO'] ? 'checked' : ''; ?>>
                    </div>
                    <div class="btn-group">
                        <input class="btn-salvar" type="submit" value="Salvar">
                        <a class="btn-cancelar" href="listar_administrador.php">Cancelar</a>

                    </div>
                </form>
            </div>

        </section>
    </main>

</body>

</html>