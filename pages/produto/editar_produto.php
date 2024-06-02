<?php

session_start(); //inicia a sessão

require_once('../../php/config/conexao.php'); //inclui o arquivo de conexão

$imagens_produto = [];
$produto_id = $_GET['produto_id'];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (empty($produto_id)) {
        echo "<p style='color:red;'>Produto não informado!</p>";
        exit();
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM PRODUTO
            INNER JOIN PRODUTO_IMAGEM ON PRODUTO.PRODUTO_ID = PRODUTO_IMAGEM.PRODUTO_ID
            LEFT JOIN CATEGORIA ON PRODUTO.CATEGORIA_ID = CATEGORIA.CATEGORIA_ID
            LEFT JOIN PRODUTO_ESTOQUE ON PRODUTO_ESTOQUE.PRODUTO_ID = PRODUTO.PRODUTO_ID
            WHERE PRODUTO.PRODUTO_ID = :produto_id;");
            $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) { //se retornar algum registro
                $produto = $stmt->fetch(PDO::FETCH_ASSOC); //retorna um array associativo com os registros

                if (isset($produto)) {
                    $img_smtp = $pdo->prepare("SELECT * FROM PRODUTO_IMAGEM WHERE PRODUTO_ID = :produto_id");
                    $img_smtp->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
                    $img_smtp->execute();
                    if ($img_smtp->rowCount() > 0) { //se retornar algum registro
                        $imagens_produto = $img_smtp->fetchAll(PDO::FETCH_ASSOC);
                    } else {
                        $imagens_produto = [];
                    }
                }
            } else {
                echo "<p style='color:red;'>Produto não encontrado!</p>";
                exit();
            }
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Erro ao listar os produtos: " . $e . "</p>"; //mensagem de erro
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $desconto = $_POST['desconto'];
    $produto_qtd = $_POST['produto_qtd'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    $categoria_id = $_POST['categoria_id'];
    $imagem_urls = $_POST['imagem_url'];
    $imagem_ordens = $_POST['imagem_ordem'];

    echo "<pre> POST";
    print_r($_POST);
    echo "</pre>";

    try {
        $sql = "UPDATE PRODUTO SET PRODUTO_NOME = :nome, PRODUTO_DESC = :descricao, PRODUTO_PRECO = :preco, PRODUTO_DESCONTO = :desconto, CATEGORIA_ID = :categoria_id, PRODUTO_ATIVO = :ativo 
        WHERE PRODUTO_ID = :produto_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
        $stmt->bindParam(':desconto', $desconto, PDO::PARAM_STR);
        $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
        $stmt->execute();

        try {
            $sql = "UPDATE PRODUTO_ESTOQUE SET PRODUTO_QTD = :produto_qtd WHERE PRODUTO_ID = :produto_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
            $stmt->bindParam(':produto_qtd', $produto_qtd, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Erro ao atualizar estoque: ' . $e->getMessage();
        }

        try {
            //Inserindo imagens no BD
            echo "<pre> imagens";
            print_r($imagens_produto);
            echo "</pre>";

            try {
                $img_smtp = $pdo->prepare("SELECT * FROM PRODUTO_IMAGEM WHERE PRODUTO_ID = :produto_id");
                $img_smtp->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
                $img_smtp->execute();
                if ($img_smtp->rowCount() > 0) { //se retornar algum registro
                    $imagens_produto = $img_smtp->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $imagens_produto = [];
                }
            } catch (PDOException $e) {
                echo 'Erro ao pegar a imagem: ' . $e->getMessage();
            }

            foreach ($imagem_urls as $index => $url) {

                echo "<pre> imagem id";
                print_r($imagens_produto[$index]['IMAGEM_ID']);
                echo "</pre>";

                $ordem = $imagem_ordens[$index];
                $sql_imagem = "UPDATE PRODUTO_IMAGEM SET IMAGEM_URL = :url_imagem, IMAGEM_ORDEM = :ordem_imagem WHERE IMAGEM_ID = :produto_id";
                $stmt_imagem = $pdo->prepare($sql_imagem);
                $stmt_imagem->bindParam(':url_imagem', $url, PDO::PARAM_STR);
                $stmt_imagem->bindParam(':ordem_imagem', $ordem, PDO::PARAM_INT);
                $stmt_imagem->bindParam(':produto_id', $imagens_produto[$index]['IMAGEM_ID'], PDO::PARAM_INT);
                $stmt_imagem->execute();
            }

            header('Location: ./painel_produtos.php?editado');
        } catch (PDOException $th) {
            echo 'Erro ao executar a atualizar imagem: ' . $th->getMessage();
        }
    } catch (PDOException $e) {
        echo 'Erro ao executar a atualizar produto: ' . $e->getMessage();
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
                                    <label for="url">URL da imagem:</label>
                                    <input type="text" id="url" name="imagem_url[]" placeholder="URL da imagem" value=" <?= $imagem['IMAGEM_URL'] ?>">
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
                </form>
            </div>
        </section>
    </main>

</body>

</html>