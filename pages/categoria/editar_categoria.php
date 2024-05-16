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
    <link rel="stylesheet" href="../../style/index.css">
    <link rel="stylesheet" href="../../style/categoria/formulario_categoria.css">
    <title>Editar Categoria</title>
</head>
<?php
require_once '../../php/config/conexao.php';
include '../../php/categoria/editar_categoria.php';
?>

<body>
    <header class="navbar">
        <div>
            <img src="../../images/fox.svg" alt="fox logo" />
            <nav>
                <ul>
                    <li><a href="../../index.php">Home</a></li>
                    <li><a href="../../pages/admin/painel_admin.php">Administradores</a></li>
                    <li><a href="../../pages/produto/painel_produtos.php">Produtos</a></li>
                </ul>
            </nav>
        </div>
        <a class="btn-sair" href="./painel_categoria.php?logout">Sair</a>
    </header>

    <main>
        <section class="container">
            <div class="sub-header">
                <h2>Editar categoria</h2>
            </div>
            <div class="container-form">
                <form action="./editar_categoria.php" method="POST" enctype="multipart/form-data">
                    <div class="campos">
                        <input type='hidden' id="categoria_id" name='categoria_id' value="<?php echo $categoria['CATEGORIA_ID']; ?>" />
                        <label for="nome_categoria">Nome :</label>
                        <input type="text" id="nome_categoria" name="nome_categoria" value="<?php echo $categoria['CATEGORIA_NOME']; ?>" required>
                    </div>
                    <div class="campos-text">
                        <label for="descricao_categoria">Descrição :</label>
                        <textarea type="text" id="descricao_categoria" name="descricao_categoria" required><?php echo $categoria['CATEGORIA_DESC']; ?></textarea>
                    </div>
                    <div class="campos">
                        <label for="categoria_ativo">Ativo :</label>
                        <input type="checkbox" id="categoria_ativo" name="categoria_ativo" value="1" <?php echo $categoria['CATEGORIA_ATIVO'] ? 'checked' : ''; ?>>
                    </div>
                    <div class="btn-group">
                        <input class="btn-salvar" type="submit" value="Salvar" />
                        <a class="btn-cancelar" href="./painel_categoria.php">Cancelar</a>
                    </div>
                </form>
            </div>
        </section>
    </main>
    
</body>

</html>