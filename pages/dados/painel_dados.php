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

                    <a class="btn-carregar" href="../../pages/produto/CadastrarProdutos.php">
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
                        <label class="dados"><?= $qtd_produtos ?></label>
                    </div>

                    <div class="dados-numeros">
                        <h3>Total em produtos <label style="color: #5BC452;">ATIVOS</label>:</h3>
                        <label class="dados"><?= $qtd_produtos_ativos ?></label>
                    </div>

                    <div class="dados-numeros">
                        <h3>Total de produtos <label style="color: #C45252;">DESATIVADOS</label>:</h3>
                        <label class="dados"><?= $qtd_produtos_desativados ?></label>
                    </div>

                    <div class="dados-numeros">
                        <h3>Total de produtos em estoque:</h3>
                        <label class="dados"><?= $total_produtos_estoque ?></label>
                    </div>

                </div>
            </div>

            <div class="dados-produtos">
                <div class="title-header">
                    <h2>Dados das Categorias:</h2>

                    <a class="btn-carregar" href="../../pages/produto/CadastrarProdutos.php">
                        Recarregar os dados
                    </a>
                </div>

                <div class="container-dados">
                    <div class="dados-numeros">
                        <h3>Qtd das categorias cadastradas:</h3>
                        <label class="dados"><?= $qtd_categorias ?></label>
                    </div>

                    <div class="dados-numeros">
                        <h3>Total de categorias <label style="color: #5BC452;">ATIVOS</label>:</h3>
                        <label class="dados"><?= $qtd_categorias_ativas ?></label>
                    </div>

                    <div class="dados-numeros">
                        <h3>Total de categorias <label style="color: #C45252;">DESATIVADOS</label>:</h3>
                        <label class="dados"><?= $qtd_categorias_desativadas ?></label>
                    </div>

                    <div class="dados-numeros">
                        <h3>Categorias mais usadas:</h3>
                        <ul>
                            <?php foreach ($categorias_mais_usadas as $categoria) : ?>
                                <li><?= $categoria['CATEGORIA_NOME']?> - <strong style="color: black;"><?= $categoria['COUNT(PRODUTO.PRODUTO_ID)']?></strong> </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="dados-produtos bottom">
                <div class="title-header">
                    <h2>Dados das vendas:</h2>

                    <a class="btn-carregar" href="../../pages/produto/CadastrarProdutos.php">
                        Recarregar os dados
                    </a>
                </div>

                <div class="container-dados">
                    <div class="dados-numeros">
                        <h3>Total de vendas:</h3>
                        <label class="dados">120</label>
                    </div>

                    <div class="dados-numeros">
                        <h3>Total de valor no estoque:</h3>
                        <label class="dados">107</label>
                    </div>

                    <div class="dados-numeros">
                        <h3>Vendas mensais:</h3>
                        <label class="dados">13</label>
                    </div>

                    <div class="dados-numeros">
                        <h3>Produtos mais vendidos:</h3>
                        <label class="dados">2000</label>
                    </div>

                </div>
            </div>

        </section>

</body>

</html>