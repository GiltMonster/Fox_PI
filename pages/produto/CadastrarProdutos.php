<?php
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../login/login.php'); //destrói a sessão caso alguém esteja logado (obriga o login na plataforma)
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
    <title>Cadastrar produtos</title>
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

            <div class="sub-header">
                <h2>Cadastrar produto</h2>
            </div>

            <!-- Contêiner principal do formulário -->
            <div class="form-container">
                <form method="post" enctype="multipart/form-data" action="../../php/produto/cadastrar_produto.php">
                    <div class="nomeProduto">
                        <label for="nome">Nome do produto:</label>
                        <input type="text" id="nome" name="nome" placeholder="Digite o nome do produto" required>
                    </div>

                    <div class="categoria">
                        <label for="categoria_id">Categoria do produto:
                        </label>
                        <select name="categoria_id" id="categoria_id" required>
                            <!-- Inclusão de categorias dinâmicas via PHP -->
                            <?php
                            include '../../php/categoria/listar_ativos.php';

                            if (!isset($categorias)) {
                                echo "<option value='0'>Nenhuma categoria cadastrada</option>";
                            } else {
                                echo "<option value='0'>Selecione uma categoria</option>";
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
                        <textarea type="text" id="descricao" name="descricao" placeholder="Digite uma descrição" required></textarea>
                    </div>

                    <div class="price-row">
                        <div class="preco">
                            <label for="preco">Preço do produto:</label>
                            <input type="number" id="preco" name="preco" required step="0.1" min="0" placeholder="Exe: 110.25">
                        </div>
                        <div class="desconto">
                            <label for="desconto">Desconto do produto:</label>
                            <input type="number" id="desconto" name="desconto" step="1" min="0" max="100" placeholder="0 - 100">
                        </div>
                        <div class="quantidade">
                            <label for="produto_qtd">Quantidade em estoque:</label>
                            <input type="number" id="produto_qtd" name="produto_qtd" step="1" min="0" placeholder="Digite o numero de itens">
                        </div>
                        <div class="ativo">
                            <label for="ativo">Produto ativo:</label>
                            <input type="checkbox" id="ativo" name="ativo" value="1">
                        </div>
                    </div>

                    <div id="containerImagens">
                        <div class="imagem-input">
                            <div class="url">
                                <label for="url">URL da imagem:</label>
                                <input type="text" name="imagem_url[]" placeholder="URL da imagem" required>
                            </div>

                            <div class="ordem">
                                <label for="ordem">Ordem:</label>
                                <input type="number" name="imagem_ordem[]" placeholder="Ordem" min="1" required>

                            </div>
                        </div>
                    </div>

                    <div class="addImagem">
                        <button type="button" onclick="adicionarImagem()">Adicionar imagem</button>
                    </div>

                    <div class="actions">
                        <input type="submit" value="Cadastrar">
                        <a class="cancel" href="./painel_produtos.php">Cancelar</a>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <script src="../../js/camposImg.js"></script>

</body>

</html>