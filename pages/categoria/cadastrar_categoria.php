<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/index.css">
    <link rel="stylesheet" href="../../style/categoria/formulario_categoria.css">
    <link rel="icon" href="../../favicon.ico" />
    <title>Cadastrar Categoria</title>
</head>

<body>
    <main>
        <header class="navbar">
            <div>
                <img src="../../images/fox.svg" alt="fox logo" />
                <nav>
                    <ul>
                        <li><a href="../../index.php">Home</a></li>
                        <li><a href="../../pages/admin/painel_admin.php">Administradores</a></li>
                        <li><a href="../../pages/produto/painel_produtos.php">Produtos</a></li>
                        <li><a href="../categoria/painel_categoria.php">Categorias</a></li>
                        <li><a href="../dados/painel_dados.php">Estatística</a></li>
                    </ul>
                </nav>
            </div>

            <a class="btn-sair" href="./painel_categoria.php?logout">Sair</a>
        </header>

        <section class="container">

            <div class="sub-header">
                <h2>Cadastrar Categoria</h2>
            </div>
            <div class="container-form">
                <form action="../../php/categoria/cadastrar_categoria.php" method="post" enctype="multipart/form-data">
                    <div class="campos">
                        <label for="nome">Nome :</label>
                        <input type="text" id="nome" name="nome" required>
                    </div>

                    <div class="campos-text">
                        <label for="descricao">Descrição:</label>
                        <textarea type="text" id="descricao" name="descricao" required></textarea>
                    </div>

                    <div class="campos">
                        <label for="categoria_ativo">Categoria ativa:</label>
                        <input type="checkbox" id="categoria_ativo" name="categoria_ativo" value="1" checked>
                    </div>

                    <div class="btn-group">
                        <input class="btn-salvar" type="submit" value="Salvar" />
                        <a class="btn-cancelar" href="./painel_categoria.php">Cancelar</a>
                    </div>
                </form>
        </section>
    </main>
</body>

</html>