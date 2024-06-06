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
    <link rel="stylesheet" href="../../style/dados/painel_dados.css">
    <link rel="icon" href="../../favicon.ico" />
    <title>Dashboard</title>
</head>

<body>
    <header class="navbar">
        <div>
            <img src="../../images/fox.svg" alt="fox logo" />
            <nav>
                <ul>
                    <li><a href="../../index.php">Home</a></li>
                    <li><a href="../admin/painel_admin.php">Administradores</a></li>
                    <li><a href="../produto/painel_produtos.php">Produtos</a></li>
                    <li><a href="../categoria/painel_categoria.php">Categorias</a></li>
                    <li><a href="../dados/painel_dados.php">Estatística</a></li>
                </ul>
            </nav>
        </div>
        <a class="btn-sair" href="./painel_dados.php?logout">Sair</a>
    </header>
    <main>
        <section class="container">

            <div class="dados-produtos">
                <div class="title-header">
                    <h2>Dados dos produtos:</h2>

                    <a class="btn-carregar" href="../../pages/dados/painel_dados.php">
                        Recarregar os dados
                    </a>
                </div>

                <?php
                require_once '../../php/config/conexao.php';
                include '../../php/data/loadDados.php';

                ?>
                <div class="container-dados">
                    <div class="dados-numeros">
                        <h3>Qtd. dos produtos cadastrados:</h3>
                        <label class="<?= $classe_css_produtos ?>"><?= $qtd_produtos ?></label>
                    </div>

                    <div class="dados-numeros">
                        <h3>Total em produtos <label style="color: #5BC452;">ATIVOS</label>:</h3>
                        <label class="<?= $classe_css_ativo ?>"><?= $qtd_produtos_ativos ?></label>
                    </div>

                    <div class="dados-numeros">
                        <h3>Total de produtos <label style="color: #C45252;">DESATIVADOS</label>:</h3>
                        <label class="<?= $classe_css_desativo ?>"><?= $qtd_produtos_desativados ?></label>
                    </div>

                    <div class="dados-numeros">
                        <h3>Total de produtos em estoque:</h3>
                        <label class="<?= $classe_css_estoque ?>"><?= $total_produtos_estoque ?></label>
                    </div>

                </div>
            </div>

            <div class="dados-produtos">
                <div class="title-header">
                    <h2>Dados das Categorias:</h2>

                    <a class="btn-carregar" href="../../pages/dados/painel_dados.php">
                        Recarregar os dados
                    </a>
                </div>

                <div class="container-dados">
                    <div class="dados-numeros">
                        <h3>Qtd das categorias cadastradas:</h3>
                        <label class="<?= $classe_css_categorias ?>"><?= $qtd_categorias ?></label>
                    </div>

                    <div class="dados-numeros">
                        <h3>Total de categorias <label style="color: #5BC452;">ATIVAS</label>:</h3>
                        <label class="<?= $classe_css_categoria_ativa?>"><?= $qtd_categorias_ativas ?></label>
                    </div>

                    <div class="dados-numeros">
                        <h3>Total de categorias <label style="color: #C45252;">DESATIVADAS</label>:</h3>
                        <label class="<?= $classe_css_categoria_desativa?>"><?= $qtd_categorias_desativadas ?></label>
                    </div>

                    <div class="dados-numeros">
                        <h3>Categorias mais usadas:</h3>
                        <?php
                        if (empty($categorias_mais_usadas)) {
                            echo '<label class="dados-erro-cat">Sem categorias!</label>';
                        } else {
                            echo "<ul>";
                            foreach ($categorias_mais_usadas as $categoria) :
                        ?>
                                <li title="<?=$categoria['CATEGORIA_NOME']?>"><?= reduzirString($categoria['CATEGORIA_NOME']) ?> - <strong style="color: #f9a80c;"><?= $categoria['COUNT(PRODUTO.PRODUTO_ID)'] ?> qtd.</strong> </li>
                        <?php
                            endforeach;
                        }
                        echo "</ul>";
                        ?>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="dados-produtos bottom">
                <div class="title-header">
                    <h2>Dados das vendas:</h2>

                    <a class="btn-carregar" href="../../pages/dados/painel_dados.php">
                        Recarregar os dados
                    </a>
                </div>

                <div class="container-dados">
                    <div class="dados-numeros">
                        <h3>Total de vendas:</h3>
                        <label class="<?=$classe_css_vendas?>"><?= $qtd_vendas ?></label>
                    </div>

                    <div class="dados-numeros">
                        <h3>Total de valor no estoque:</h3>
                        <label class="<?= $classe_css_valor_estoque?>"><?= $total_valor_estoque ?></label>
                    </div>

                    <div class="dados-numeros">
                        <h3>Total em valor das vendas:</h3>
                        <label class="<?= $classe_css_total_vendas?>"><?= $total_vendas ?></label>
                    </div>

                    <div class="dados-numeros">
                        <h3>Produtos mais vendidos:</h3>
                        <?php
                        if (empty($produtos_mais_vendidos)) {
                            echo '<label class="dados-erro">Sem vendas!</label>';
                        } else {
                            echo "<ul>";
                            foreach ($produtos_mais_vendidos as $produto) :
                        ?>
                                <li title="<?=$produto['PRODUTO_NOME']?>"><?= reduzirString($produto['PRODUTO_NOME']) ?> - <strong style="color: #f9a80c;"><?= $produto['ITEM_QTD'] ?> qtd.</strong> </li>
                        <?php endforeach;
                            echo "</ul>";
                        } ?>
                    </div>

                </div>
            </div>

        </section>

</body>

</html>