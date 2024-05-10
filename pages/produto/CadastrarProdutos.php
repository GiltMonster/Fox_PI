<?php
session_start(); //inicia a sessão
require_once('../../php/config/conexao.php'); //inclui os metodos de conexão do arquivo conexao.php

// if (!isset($_SESSION['admin_logado'])) { //se não existir a sessão admin_logado
//     header('Location: ./login.php'); //redireciona para a página login.php
//     exit(); //finaliza a execução do script
// }

try {
    $categorias = $pdo->prepare('SELECT * FROM CATEGORIA');
    $categorias->execute(); //executa a query
    $categorias = $categorias->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Erro ao executar a ao pegar a categoria: ' . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $desconto = $_POST['desconto'];
    $categoria_id = $_POST['categoria_id'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    $imagem_urls = $_POST['imagem_url'];
    $imagem_ordens = $_POST['imagem_ordem'];

    $produto_qtd = $_POST['produto_qtd'];

    print_r($_POST);
    try {
        $sql = "INSERT INTO PRODUTO (PRODUTO_NOME, PRODUTO_DESC, PRODUTO_PRECO, PRODUTO_DESCONTO, CATEGORIA_ID, PRODUTO_ATIVO) 
         VALUES (:nome, :descricao, :preco, :desconto, :categoria_id, :ativo)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
        $stmt->bindParam(':desconto', $desconto, PDO::PARAM_STR);
        $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
        $stmt->execute();

        $produto_id = $pdo->lastInsertId();

        try {
            $sql = "INSERT INTO PRODUTO_ESTOQUE (PRODUTO_ID, PRODUTO_QTD) 
            VALUES (:produto_id, :produto_qtd)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_STR);
            $stmt->bindParam(':produto_qtd', $produto_qtd, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Erro ao executar a cadastrar estoque: ' . $e->getMessage();
        }

         try {
            //Inserindo imagens no BD
         foreach($imagem_urls as $index => $url){
            $ordem = $imagem_ordens[$index];
            $sql_imagem = "INSERT INTO PRODUTO_IMAGEM(IMAGEM_URL, PRODUTO_ID, IMAGEM_ORDEM ) VALUES (:url_imagem, :produto_id, :ordem_imagem)";
            $stmt_imagem = $pdo->prepare($sql_imagem);
            $stmt_imagem->bindParam(':url_imagem', $url, PDO::PARAM_STR);
            $stmt_imagem->bindParam(':produto_id', $produto_id, PDO::PARAM_STR);
            $stmt_imagem->bindParam(':ordem_imagem', $ordem, PDO::PARAM_INT);
            $stmt_imagem->execute();
        }
        echo "<p style='color:green;'>Produto cadastrado com sucesso</p>";
         } catch (PDOException $th) {
                echo 'Erro ao executar a cadastrar imagem: ' . $th->getMessage();
         }
    } catch (PDOException $e) {
        echo 'Erro ao executar a cadastrar produto: ' . $e->getMessage();
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
    <title>Cadastrat produtos</title>
</head>

<body>
    <header class="navbar">
        <h1>Fox brinquedos</h1>
        <nav>
            <ul>
                <li><a href="../../index.php">Produtos</a></li>
                <li><a href="../admin/painel_admin.php">Administrador</a></li>
                <li><a href="./painel_produtos.php"> Produtos</a></li>
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

            <div class="form-container">
                <form method="post" enctype="multipart/form-data">
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