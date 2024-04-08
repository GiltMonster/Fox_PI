<?php
session_start(); //inicia a sessão
require_once('./conexao.php'); //inclui os metodos de conexão do arquivo conexao.php

// if (!isset($_SESSION['admin_logado'])) { //se não existir a sessão admin_logado
//     header('Location: ./login.php'); //redireciona para a página login.php
//     exit(); //finaliza a execução do script
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //se o formulário foi submetido
    $nome = $_POST['nome']; //recebe o nome do produto
    $descricao = $_POST['descricao']; //recebe a descrição do produto
    $preco = $_POST['preco']; //recebe o preço do produto
    $url_img = $_POST['url_img']; //recebe a url da imagem do produto

    $imagem = $_FILES['imagem']['name']; //recebe o nome do arquivo da imagem

    if(move_uploaded_file($_FILES['imagem']['tmp_name'], $target_file)){ //manda a imagem para um arquivo temporar
        echo "<p>Imagem ".basename( $imagem )." foi carregada com sucesso!</p>";
    }else{
        echo $target_file;
        echo "Falha ao carregar ".basename( $imagem )." ,tente novamente!";
    }

    try {

        $sql = "INSERT INTO PRODUTO(`CATEGORIA_ID`, `PRODUTO_ATIVO`, `PRODUTO_DESC`, `PRODUTO_DESCONTO`, `PRODUTO_ID`, `PRODUTO_NOME`, `PRODUTO_PRECO`) VALUES (:nome, :descricao, :preco, :imagem, :url_img)"; //consulta SQL
        $query = $pdo->prepare($sql); //prepara a consulta SQL

        $query->bindParam(':nome', $nome, PDO::PARAM_STR); //substitui o parâmetro :nome pelo valor da variável $nome
        $query->bindParam(':descricao', $descricao, PDO::PARAM_STR); //substitui o parâmetro :descricao pelo valor da variável $descricao
        $query->bindParam(':preco', $preco, PDO::PARAM_STR); //substitui o parâmetro :preco pelo valor da variável $preco
        $query->bindParam(':imagem', $target_file, PDO::PARAM_STR); //substitui o parâmetro :imagem pelo valor da variável $imagem
        $query->bindParam(':url_img', $url_imagem_produtos, PDO::PARAM_STR); //substitui o parâmetro :url_img pelo valor da variável $url_imagem_produtos
        $query->execute(); //executa a consulta SQL

        // echo "<p style='color:green;'>Produto cadastrado com sucesso!</p>"; //mensagem de sucesso

        header('Location: ../pages/CadastrarProdutos.php?sucesso'); //redireciona para a página painel_admin.php

    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao cadastrar o produto:" . $e . "</p>"; //mensagem de erro
    }
}

?>

<!-- <!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cadastro produto</title>
</head>

<body>
    <h2>Cadastro de Produto</h2>
    <form action="./cadastrar_produto.php" method="post" enctype="multipart/form-data">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <p></p>
        <label for="descricao">Descrição:</label>
        <textarea type="text" id="descricao" name="descricao" required></textarea>
        <p></p>
        <label for="preco">Preço:</label>
        <input type="number" id="preco" name="preco" step="10" required>
        <p></p>
        <label for="imagem">Imagem:</label>
        <input type="file" id="imagem" name="imagem" required>
        <p></p>
        <label for="url_img">url da imagem:</label>
        <input type="text" id="url_img" name="url_img">
        <p></p>
        <input type="submit" value="Cadastrar">
    </form>
</body>

</html> -->