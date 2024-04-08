<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/index.css">
    <link rel="stylesheet" href="../style/cadastrar_produtos.css">
    <title>Cadastrat produtos</title>
</head>

<body>
    <header class="navbar">
        <h1>Fox brinquedos</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Produtos</a></li>
                <li><a href="./CadastrarProdutos.php">Cadastrar produtos</a></li>
                <li><a href="./ExcluirOuEditarProdutos.html">Editar ou excluir os produtos</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="container">
            <h2>Seja bem-vindo!</h2>
            <p>Para cadastrar um produto, preencha os campos abaixo:</p>
            <div class="form-container">
                <form action="../php/cadastrar_produto.php" method="post" enctype="multipart/form-data">
                    <label for="nome_produto">Nome do produto:</label>
                    <input type="text" id="nome_produto" name="nome" required>
                    <label for="produto_desc">Descrição do produto:</label>
                    <textarea type="text" id="produto_desc" name="descricao" required></textarea>
                    <label for="preco">Preço do produto:</label>
                    <input type="number" id="preco" name="preco" step="10" required>
                    <label for="imagem">Imagem do produto:</label>
                    <input type="file" id="imagem" name="imagem" required>
                    <label for="url_img">URL da imagem do produto:</label>
                    <input type="text" id="url_img" name="url_img">

                    CATEGORIA_ID`, `PRODUTO_ATIVO`, `PRODUTO_DESC`, `PRODUTO_DESCONTO`, `PRODUTO_ID`,  `PRODUTO_PRECO
                    <input type="submit" value="Cadastrar">
                    <?php
                    if (isset($_GET['sucesso'])) { //suceeso é um parâmetro que é passado na URL
                        echo '<p class="msg-sucesso">Produto cadastrado com sucesso!</p>';
                    }
                    ?>
                </form>
            </div>
        </section>
    </main>


</body>

</html>