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
    <link rel="stylesheet" href="../../style/produto/painel_produto.css">
    <link rel="stylesheet" href="../../style/carrossel.css">
    <link rel="stylesheet" href="../../style/alerts.css">
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

        <a class="btn-sair" href="./painel_produtos.php?logout">Sair</a>
    </header>
    <main>
        <section class="container">

            <div class="pesquisa-header">
                <h2>Estoque</h2>

                <form method="POST" class="pesquisa-form">
                    <input type="text" placeholder="Buscar produto" name="produto_nome" required/>
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


            if ($_SERVER['REQUEST_METHOD'] == 'GET') {

                include '../../php/produto/listar_produto.php';

                // Itera sobre os produtos para exibi-los na tabela
                foreach ($produtos as $produto) :
            ?>
                    <div class="card-container">
                        <div class="card-content">

                            <div class="slideshow-container">
                                <?php if (isset($imagens_produto[$produto['PRODUTO_ID']]) && !empty($imagens_produto[$produto['PRODUTO_ID']])) : ?>
                                    <?php foreach ($imagens_produto[$produto['PRODUTO_ID']] as $imagem) : ?>
                                        <div class="mySlides fade">
                                            <img src="<?php echo $imagem['IMAGEM_URL']; ?>" alt="<?php echo $produto['PRODUTO_NOME']; ?>" style="width: 100px;"> <!-- Substitua 'caminho_da_imagem' pelo nome correto da coluna no seu banco de dados -->
                                        </div>
                                    <?php endforeach; ?>

                                    <div class="container-prev-next">
                                        <a class="prev" onclick="this.parentElement.parentElement.slideshowInstance.plusSlides(-1)">&#10094;</a>
                                        <a class="next" onclick="this.parentElement.parentElement.slideshowInstance.plusSlides(1)">&#10095;</a>
                                    </div>
                                <?php else : ?>
                                    <p>Nenhuma imagem disponível.</p>
                                <?php endif; ?>


                                <div style="text-align:center">
                                    <?php if (isset($imagens_produto[$produto['PRODUTO_ID']]) && !empty($imagens_produto[$produto['PRODUTO_ID']])) : ?>
                                        <?php foreach ($imagens_produto[$produto['PRODUTO_ID']] as $imagem) : ?>
                                            <span class="dot" onclick="this.parentElement.parentElement.slideshowInstance.currentSlide(<?= $imagem['IMAGEM_ORDEM'] ?>)"></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="text-container">
                                <div class="descricao">
                                    <h1><?= $produto['PRODUTO_NOME'] ?></h1>
                                    <?= $produto['PRODUTO_DESC'] ? "<p>$produto[PRODUTO_DESC]</p>" : 'Sem descrição'; ?>
                                </div>

                                <div class="quantidade-preco">
                                    <p>Preço: <?= $produto['PRODUTO_PRECO'] ?></p>
                                    <p>Categoria: <?= $produto['CATEGORIA_NOME'] ?></p>
                                    <p>Quantidade: <?= $produto['PRODUTO_QTD'] ? $produto['PRODUTO_QTD'] : "Quantidade não informada" ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-buttons">
                            <a class="btn-alterar" href="./editar_produto.php?produto_id=<?= $produto['PRODUTO_ID'] ?>">Alterar</a>
                            <a class="btn-excluir">Excluir</a>
                        </div>
                    </div>
                    <?php endforeach;
            } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
                include_once '../../php/produto/pesquisar_produto.php';
                if ($prods_pesquisados) {

                    echo '
                    <div class="pesquisa-header">
                    <h3>produto pesquisado: <label style="color:#f9a80c">' . $_POST['produto_nome'] . '</label></h3>
                    <a class="btn-limpa-pesquisa" href="./painel_produtos.php">Limpar pesquisa</a>
                    </div>
                    ';

                    foreach ($prods_pesquisados as $produto) :

                    ?>
                        <div class="card-container">
                            <div class="card-content">

                                <div class="slideshow-container">
                                    <?php if (isset($imagens_produto[$produto['PRODUTO_ID']]) && !empty($imagens_produto[$produto['PRODUTO_ID']])) : ?>
                                        <?php foreach ($imagens_produto[$produto['PRODUTO_ID']] as $imagem) : ?>
                                            <div class="mySlides fade">
                                                <img src="<?php echo $imagem['IMAGEM_URL']; ?>" alt="<?php echo $produto['PRODUTO_NOME']; ?>" style="width: 100px;"> <!-- Substitua 'caminho_da_imagem' pelo nome correto da coluna no seu banco de dados -->
                                            </div>
                                        <?php endforeach; ?>

                                        <div class="container-prev-next">
                                            <a class="prev" onclick="this.parentElement.parentElement.slideshowInstance.plusSlides(-1)">&#10094;</a>
                                            <a class="next" onclick="this.parentElement.parentElement.slideshowInstance.plusSlides(1)">&#10095;</a>
                                        </div>
                                    <?php else : ?>
                                        <p>Nenhuma imagem disponível.</p>
                                    <?php endif; ?>

                                    <div style="text-align:center">
                                        <?php if (isset($imagens_produto[$produto['PRODUTO_ID']]) && !empty($imagens_produto[$produto['PRODUTO_ID']])) : ?>
                                            <?php foreach ($imagens_produto[$produto['PRODUTO_ID']] as $imagem) : ?>
                                                <span class="dot" onclick="this.parentElement.parentElement.slideshowInstance.currentSlide(<?= $imagem['IMAGEM_ORDEM'] ?>)"></span>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="text-container">
                                    <div class="descricao">
                                        <h1><?= $produto['PRODUTO_NOME'] ?></h1>
                                        <?= $produto['PRODUTO_DESC'] ? "<p>$produto[PRODUTO_DESC]</p>" : 'Sem descrição'; ?>
                                    </div>

                                    <div class="quantidade-preco">
                                        <p>Preço: <?= $produto['PRODUTO_PRECO'] ?></p>
                                        <p>Categoria: <?= $produto['CATEGORIA_NOME'] ?></p>
                                        <p>Quantidade: <?= $produto['PRODUTO_QTD'] ? $produto['PRODUTO_QTD'] : "Quantidade não informada" ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-buttons">
                                <a class="btn-alterar" href="./editar_produto.php?produto_id=<?= $produto['PRODUTO_ID'] ?>">Alterar</a>
                                <a class="btn-excluir">Excluir</a>
                            </div>
                        </div>
            <?php endforeach;
                } else {
                    echo '
                    <div class="pesquisa-header">
                    <h3>produto pesquisado: <label style="color:#f9a80c">' . $_POST['produto_nome'] . '</label></h3>
                    <a class="btn-limpa-pesquisa" href="./painel_produtos.php">Limpar pesquisa</a>
                    </div>
                    ';
                    echo "
                    <div class='notes danger'>
                        <p>Nenhum produto encontrado</p>
                    </div>
                    ";
                }
            }
            ?>
        </section>
    </main>
</body>

<script src="../../js/carrossel.js"> </script>

</html>