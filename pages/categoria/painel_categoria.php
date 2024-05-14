<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel categoria.</title>
    <link rel="stylesheet" href="../../style/index.css">
    <link rel="stylesheet" href="../../style/categoria/painel_categoria.css">
</head>

<body>

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

                <div class="pesquisa-header">
                    <h2>Categorias</h2>

                    <form method="POST" class="pesquisa-form">
                        <input type="text" placeholder="Buscar categoria" name="categoria_nome" required />
                        <button type="submit">
                            <img src="../../images/icons/search.svg" alt="search">
                        </button>

                    </form>

                    <a class="btn-categoria" href="./cadastrar_categoria.php">
                        <label>
                            Cadastrar categoria
                        </label>
                    </a>
                </div>
            </section>
        </main>

    </body>

</html>