<?php

session_start(); //inicia a sessão

require_once('../../php/config/conexao.php'); //inclui o arquivo de conexão

try {
    $categorias = $pdo->prepare('SELECT * FROM CATEGORIA');
    $categorias->execute(); //executa a query
    $categorias = $categorias->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Erro ao executar a ao pegar a categoria: ' . $e->getMessage();
}

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $produto_id = $_GET['produto_id'];
    if(empty($produto_id)){
        echo "<p style='color:red;'>Produto não informado!</p>";
        exit();
    }else{
        try{
            $stmt = $pdo->prepare("SELECT * FROM PRODUTO
            INNER JOIN PRODUTO_IMAGEM ON PRODUTO.PRODUTO_ID = PRODUTO_IMAGEM.PRODUTO_ID
            LEFT JOIN CATEGORIA ON PRODUTO.CATEGORIA_ID = CATEGORIA.CATEGORIA_ID
            LEFT JOIN PRODUTO_ESTOQUE ON PRODUTO_ESTOQUE.PRODUTO_ID = PRODUTO.PRODUTO_ID
            WHERE PRODUTO.PRODUTO_ID = :produto_id;");
            $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) { //se retornar algum registro
                $produto = $stmt->fetch(PDO::FETCH_ASSOC); //retorna um array associativo com os registros
                
                echo "<pre> produtos";
                print_r($produto);
                echo "</pre>";
            } else {
                echo "<p style='color:red;'>Produto não encontrado!</p>";
                exit();
            }
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Erro ao listar os produtos: " . $e . "</p>"; //mensagem de erro
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/index.css">
    <link rel="stylesheet" href="../../style/produto/cadastrar_produtos.css">
    <title>Excluir ou Editar os Produtos</title>
</head>
<body>

    <header class="navbar">
        <h1>Fox brinquedos</h1>
        <nav>
            <ul>
                <li><a href="../../index.php">Home</a></li>
                <li><a href="../admin/painel_admin.php">Administradores</a></li>
                <li><a href="./painel_produtos.php">Produtos</a></li>
            </ul>
        </nav>
    </header>

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

<!-- (
    [CATEGORIA_ID] => 2
    [PRODUTO_ATIVO] => 1
    [PRODUTO_DESC] => boneca de platico
    [PRODUTO_DESCONTO] => 40.00
    [PRODUTO_ID] => 23
    [PRODUTO_NOME] => boneca
    [PRODUTO_PRECO] => 90.00
    [IMAGEM_ID] => 2
    [IMAGEM_ORDEM] => 1
    [IMAGEM_URL] => https://static.wikia.nocookie.net/herois/images/5/58/Ken_TS3.png/revision/latest?cb=20221227032159&path-prefix=pt-br
    [CATEGORIA_NOME] => Boneco
    [CATEGORIA_DESC] => de plastico
    [CATEGORIA_ATIVO] => 1
    [PRODUTO_QTD] => 10
) -->

            <div class="form-container">
                <form method="post" enctype="multipart/form-data">
                    <label for="nome">Nome do produto:</label>
                    <input type="text" id="nome" name="nome" value="<?php echo $produto['PRODUTO_NOME']; ?>">

                    <label for="descricao">Descrição do produto:</label>
                    <input type="text" id="descricao" name="descricao" value="<?php echo $produto['PRODUTO_DESC']; ?>"></input>

                    <label for="preco">Preço do produto:</label>
                    <input type="number" id="preco" name="preco" step="10" value="<?php echo $produto['PRODUTO_PRECO']; ?>">

                    <label for="desconto">Desconto do produto:</label>
                    <input type="number" id="desconto" name="desconto" step="10" value="<?php echo $produto['PRODUTO_DESCONTO']; ?>">

                    <label for="produto_qtd">Quantidade em estoque:</label>
                    <input type="number" id="produto_qtd" name="produto_qtd" step="1" value="<?php echo $produto['PRODUTO_QTD']; ?>">

                    <label for="ativo">Produto ativo:</label>
                    <input type="checkbox" id="ativo" name="ativo" value="1" <?php echo $produto['PRODUTO_ATIVO'] ? 'checked' : '' ;?>>

                    <label for="categoria_id">Categoria do produto:</label>
                    <select name="categoria_id" id="categoria_id" value="<?php echo $produto['CATEGORIA_ID']; ?>">
                        <?php
                        //loop para exibir as categorias
                        foreach ($categorias as $categoria) :
                        ?>
                            <option value="<?php echo $categoria['CATEGORIA_ID']; ?>"><?php echo $categoria['CATEGORIA_NOME']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <a href="../../pages/categoria/cadastrar_categoria.php">+</a>

                    <div id="containerImagens">
                        <input type="text" name="imagem_url[]" placeholder="URL da imagem" value="<?php echo $produto['IMAGEM_URL']; ?>">
                        <input type="number" name="imagem_ordem[]" placeholder="Ordem" min="1" value="<?php echo $produto['IMAGEM_ORDEM']; ?>">
                    </div>
                    <button onclick="adicionarImagem()" class="add_img">Adicionar imagem</button>
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