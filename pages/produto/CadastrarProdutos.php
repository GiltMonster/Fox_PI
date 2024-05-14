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

        <main>
            <section class="container">
                <h2>Seja bem-vindo!</h2>
                <p>Para cadastrar um produto, preencha os campos abaixo:</p>

                <script>
                    function adicionarImagem() {
                        const containerImagens = document.getElementById('containerImagens');
                        const novoDiv = document.createElement('div');
                        novoDiv.className = 'imagem-input';

                        const novoInputURL = document.createElement('input');
                        novoInputURL.type = "text";
                        novoInputURL.name = 'imagem_url[]';
                        novoInputURL.placeholder = 'URL da imagem';
                        novoInputURL.required = true;

                        const novoInputOrdem = document.createElement('input');
                        novoInputOrdem.type = "number";
                        novoInputOrdem.name = 'imagem_ordem[]';
                        novoInputOrdem.placeholder = 'Ordem';
                        novoInputOrdem.min = '1'
                        novoInputOrdem.required = true;


                        novoDiv.appendChild(novoInputURL);
                        novoDiv.appendChild(novoInputOrdem);

                        containerImagens.appendChild(novoDiv);
                    }
                </script>

                <div class="form-container">
                    <form method="post" enctype="multipart/form-data" action="../../php/produto/cadastrar_produto.php">
                        <label for="nome">Nome do produto:</label>
                        <input type="text" id="nome" name="nome" required>

                        <label for="descricao">Descrição do produto:</label>
                        <textarea type="text" id="descricao" name="descricao" required></textarea>

                        <label for="preco">Preço do produto:</label>
                        <input type="number" id="preco" name="preco" step="10" required>

                        <label for="desconto">Desconto do produto:</label>
                        <input type="number" id="desconto" name="desconto" step="10">

                        <label for="produto_qtd">Quantidade em estoque:</label>
                        <input type="number" id="produto_qtd" name="produto_qtd" step="1">

                        <label for="ativo">Produto ativo:</label>
                        <input type="checkbox" id="ativo" name="ativo" value="1">

                        <label for="categoria_id">Categoria do produto:</label>
                        <select name="categoria_id" id="categoria_id" require>
                            <?php
                            include '../../php/categoria/listar_categoria.php';
                            // var_dump($categorias);
                            //loop para exibir as categorias
                            foreach ($categorias as $categoria) :
                            ?>
                                <option value="<?php echo $categoria['CATEGORIA_ID']; ?>"><?php echo $categoria['CATEGORIA_NOME']; ?></option>
                            <?php endforeach; ?>
                        </select>

                        <a href="../../pages/categoria/cadastrar_categoria.php">+</a>

                        <div id="containerImagens">
                            <input type="text" name="imagem_url[]" placeholder="URL da imagem" required>
                            <input type="number" name="imagem_ordem[]" placeholder="Ordem" min="1" required>
                        </div>
                        <button onclick="adicionarImagem()">Adicionar imagem</button>
                        <input type="submit" value="Cadastrar">
                </div>

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