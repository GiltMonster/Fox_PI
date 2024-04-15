<?php
session_start(); //inicia a sessão
require_once('conexao.php'); //inclui os metodos de conexão do arquivo conexao.php

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
    $imagens = $_POST['imagem_url'];
    $produto_qtd = $_POST['produto_qtd'];

    //echo $nome . '<br>' . $descricao . '<br>' . $preco . '<br>' . $desconto . '<br>' . $categoria_id . '<br>' . $ativo . '<br>' . $imagens;

    try {
        $sql = "INSERT INTO PRODUTO (PRODUTO_NOME, PRODUTO_DESC, PRODUTO_PRECO, PRODUTO_DESCONTO, CATEGORIA_ID, PRODUTO_ATIVO) 
         VALUES (:nome, :descricao, :preco, :desconto, :categoria_id, :ativo)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
        $stmt->bindParam(':desconto', $desconto, PDO::PARAM_STR);
        $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_STR);
        $stmt->execute();

        $produto_id = $pdo->lastInsertId();

        foreach ($imagens as $ordem => $url_imagem) {
            $sql = "INSERT INTO PRODUTO_IMAGEM (IMAGEM_URL, PRODUTO_ID, IMAGEM_ORDEM) 
            VALUES (:url_imagem, :produto_id, :ordem)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':url_imagem', $url_imagem, PDO::PARAM_STR);
            $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_STR);
            $stmt->bindParam(':ordem', $ordem, PDO::PARAM_STR);
            $stmt->execute();
        }

        $sql = "INSERT INTO PRODUTO_ESTOQUE (PRODUTO_ID, PRODUTO_QTD) 
        VALUES (:produto_id, :produto_qtd)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_STR);
        $stmt->bindParam(':produto_qtd', $produto_qtd, PDO::PARAM_STR);
        $stmt->execute();

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
    <link rel="stylesheet" href="../style/index.css">
    <link rel="stylesheet" href="../style/cadastrar_produtos.css">
    <title>Cadastrar produtos</title>
</head>

<body>
    <header>
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
        <section>
            <h2>Seja bem-vindo!</h2>
            <p>Para cadastrar um produto, preencha os campos abaixo:</p>

            <script>
                function adicionarImagem() {
                    const containerImagens = document.getElementById('containerImagens');
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.name = 'imagem_url[]';
                    input.required = true;
                    containerImagens.appendChild(input);
                }
            </script>

            <div>
                <form method="post" enctype="multipart/form-data">
                    <label for="nome">Nome do produto:</label>
                    <input type="text" id="nome" name="nome" required>
                    <p></p>
                    <label for="descricao">Descrição do produto:</label>
                    <textarea type="text" id="descricao" name="descricao" required></textarea>
                    <p></p>
                    <label for="preco">Preço do produto:</label>
                    <input type="number" id="preco" name="preco" step="0.01" required>
                    <p></p>
                    <label for="desconto">Desconto do produto:</label>
                    <input type="number" id="desconto" name="desconto" step="0.01">
                    <p></p>
                    <label for="ativo">Produto ativo:</label>
                    <input type="checkbox" id="ativo" name="ativo" value="1">
                    <p></p>
                    <label for="categoria_id">Categoria do produto:</label>
                    <select name="categoria_id" id="categoria_id" require>
                        <?php

                        echo var_dump($categorias);
                        //loop para exibir as categorias
                        foreach ($categorias as $categoria):
                        ?>
                            <option value="<?php echo $categoria['CATEGORIA_ID']; ?>"><?php echo $categoria['CATEGORIA_NOME']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <p></p>
                    <label for="imagem">Imagem do produto:</label>
                    <div id="containerImagens">
                        <input type="text" name="imagem_url[]" required>
                    </div>
                    <p></p>
                    <button onclick="adicionarImagem()">Adicionar imagem</button>
                    <p></p>
                    <label for="produto_qtd">Estoque:</label>
                    <input type="number" id="produto_qtd" name="produto_qtd" step="01">
                    <p></p>
                    <input type="submit" value="Cadastrar">
                    <?php
                    if (isset($_GET['sucesso'])) { //sucesso é um parâmetro que é passado na URL
                        echo '<p class="msg-sucesso">Produto cadastrado com sucesso!</p>';
                    }
                    ?>
                </form>
            </div>
        </section>
    </main>


</body>

</html>