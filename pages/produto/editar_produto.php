<?php
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../login/login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/index.css">
    <link rel="stylesheet" href="../../style/produto/cadastrar_produtos.css">
    <link rel="icon" href="../../favicon.ico" />
    <title>Editar os Produtos</title>
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
                    <li><a href="../categoria/painel_categoria.php">Categorias</a></li>
                    <li><a href="../dados/painel_dados.php">Estatística</a></li>
                </ul>
            </nav>
        </div>

        <a class="btn-sair" href="./painel_produtos.php?logout">Sair</a>
    </header>

    <main>
        <section class="container">

            <div class="sub-header">
                <h2>Editar os produto</h2>
            </div>

            <!-- Contêiner principal do formulário -->
            <div class="form-container">

                <?php
                require_once '../../php/config/conexao.php';
                include '../../php/produto/editar_produto.php';
                ?>
                <form method="post" enctype="multipart/form-data">
                    <div class="nomeProduto">
                        <label for="nome">Nome do produto:</label>
                        <input type="text" id="nome" name="nome" value="<?php echo $produto['PRODUTO_NOME']; ?>">
                    </div>

                    <div class="categoria">
                        <label for="categoria_id">Categoria do produto:</label>
                        <select name="categoria_id" id="categoria_id" value="<?php echo $produto['CATEGORIA_ID']; ?>">
                            <?php
                            include '../../php/categoria/listar_ativos.php';

                            if (!isset($categorias)) {
                                echo "<option>Nenhuma categoria cadastrada</option>";
                            } else {
                                echo "<option value=" . $produto['CATEGORIA_ID'] . ">" . $produto['CATEGORIA_NOME'] . "</option>";
                                foreach ($categorias as $categoria) : ?>
                                    <option value="<?php echo $categoria['CATEGORIA_ID']; ?>"><?php echo $categoria['CATEGORIA_NOME']; ?></option>

                            <?php
                                endforeach;
                            }
                            ?>
                        </select>
                    </div>

                    <div class="descricao">
                        <label for="descricao">Descrição do produto:</label>
                        <textarea type="text" id="descricao" name="descricao" placeholder="Digite uma descrição"><?= $produto['PRODUTO_DESC']; ?></textarea>
                    </div>
                    <div class="price-row">

                        <div class="preco">
                            <label for="preco">Preço do produto:</label>
                            <input type="number" id="preco" name="preco" step="0.01" min="0" placeholder="Exe: 110.25" value="<?php echo $produto['PRODUTO_PRECO']; ?>">
                        </div>
                        <div class="desconto">
                            <label for="desconto">Desconto do produto:</label>
                            <input type="number" id="desconto" name="desconto" step="1" min="0" max="100" placeholder="0 - 100" value="<?php echo $produto['PRODUTO_DESCONTO']; ?>">
                        </div>
                        <div class="quantidade">
                            <label for="produto_qtd">Quantidade em estoque:</label>
                            <input type="number" id="produto_qtd" name="produto_qtd" step="1" min="0" placeholder="Digite o numero de itens" value="<?php echo $produto['PRODUTO_QTD']; ?>">
                        </div>
                        <div class="ativo">
                            <label for="ativo">Produto ativo:</label>
                            <input type="checkbox" id="ativo" name="ativo" value="1" <?php echo $produto['PRODUTO_ATIVO'] ? 'checked' : ''; ?>>
                        </div>
                    </div>

                    <?php
                    foreach ($imagens_produto as $imagem) :
                    ?>
                        <div id="containerImagens">
                            <div class="imagem-input">
                                <div class="url">
                                    <label for="url">Imagem atual:</label>
                                    <img style="width: 100px; height: auto;" id="url" src=" <?= $imagem['IMAGEM_URL'] ?>">
                                </div>
                                <div class="url">
                                    <label for="url">Nova imagem:</label>
                                    <input type="file" id="url" name="imagem_url[]">
                                </div>

                                <div class="ordem">
                                    <label for="ordem">Ordem:</label>
                                    <input type="number" id="ordem" name="imagem_ordem[]" placeholder="Ordem" min="1" value="<?= $imagem['IMAGEM_ORDEM'] ?>">
                                </div>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>

                    <input type="submit" value="Atualizar">
                    <a href="./painel_produtos.php" class="cancel">Cancelar</a>
                </form>
            </div>
        </section>
    </main>

</body>

</html>