<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/index.css">
    <link rel="stylesheet" href="../../style/produto/painel_produto.css">
    <title>Painel de Produtos</title>
</head>

<body>
    <header class="navbar">
        <div>
            <img src="../../images/fox.svg" alt="fox logo" />
            <nav>
                <ul>
                    <li><a href="../../index.php">Home</a></li>
                    <li><a href="../../pages/admin/painel_admin.php">Administradores</a></li>
                    <li><a href="./painel_produtos.php">Produtos</a></li>
                </ul>
            </nav>
        </div>

        <button class="btn-sair">Sair</button>
    </header>
    <main>
        <section class="container">


            <div class="pesquisa-header">
                <h2>Estoque</h2>

                <form method="POST" class="pesquisa-form">
                    <input type="text" placeholder="Buscar produto" name="produto_nome" />
                    <button type="submit">
                        <img src="../../images/icons/search.svg" alt="search">
                    </button>


                </form>
                <a class="btn-produto" href="../../pages/produto/CadastrarProdutos.php">
                    <label>
                        Cadastrar produto
                    </label>
                </a>

            </div>

            <?php
            require_once('../../php/config/conexao.php');
            include '../../php/produto/listar_produto.php';

            // Itera sobre os produtos para exibi-los na tabela
            foreach ($produtos as $produto) :
            ?>

                <div class="card-container">
                    <div class="card-content">
                        <img src="https://via.placeholder.com/250" alt="produto" />
                        <div class="text-container">
                            <div class="descricao">
                                <h1><?= $produto['PRODUTO_NOME'] ?></h1>
                                <?= $produto['PRODUTO_DESC'] ? "<p>$produto[PRODUTO_DESC]</p>" : 'Sem descrição';?>
                            </div>

                            <div class="quantidade-preco">
                                <p>Preço: <?= $produto['PRODUTO_PRECO'] ?></p>
                                <p>Categoria: <?= $produto['CATEGORIA_NOME'] ?></p>
                                <p>Quantidade: <?= $produto['PRODUTO_QTD'] ? $produto['PRODUTO_QTD'] : "Quantidade não informada" ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-buttons">
                        <button class="btn-alterar">Alterar</button>
                        <button class="btn-excluir">Excluir</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
</body>

</html>