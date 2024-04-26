<?php
session_start(); //inicia a sessão
require_once('../../php/config/conexao.php'); //inclui os métodos de conexão do arquivo conexao.php

// if (!isset($_SESSION['admin_logado'])) { //se não existir a sessão admin_logado
//     header('Location:login.php'); //redireciona para a página login.php
//     exit(); //finaliza a execução do script
// }

//se a pagina foi acessada via GET e o adm_id foi informado por path param na URL 
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $categoria_id = $_GET['categoria_id']; //recebe o adm_id do adm
    if (empty($categoria_id)) { //se o adm_id estiver vazio
        echo "<p style='color:red;'>categoria_id da categoria não informado!</p>"; //mensagem de erro
        exit(); //finaliza a execução do script
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM CATEGORIA WHERE CATEGORIA_ID = :categoria_id"); //consulta SQL
            $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT); //substitui o parâmetro :adm_id pelo valor da variável $adm_id
            $stmt->execute(); //executa a consulta SQL
            if ($stmt->rowCount() > 0) { //se retornar algum registro
                $categoria = $stmt->fetch(PDO::FETCH_ASSOC); //retorna um array associativo com os registros
                //echo var_dump($administrador); informa o tipo e os valors dos campos a serem trabalhados
            } else {
                echo "<p style='color:red;'>Categoria não encontrada!</p>"; //mensagem de erro
                exit(); //finaliza a execução do script
            }
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Erro ao buscar categoria: " . $e->getMessage() . "</p>"; //mensagem de erro
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //se o formulário foi submetido
    $categoria_id = $_POST['categoria_id']; //recebe o categoria_id da categoria
    $nome_categoria = $_POST['nome_categoria'];
    $descricao_categoria = $_POST['descricao_categoria'];
    $categoria_ativo = isset($_POST['categoria_ativo']) ? 1 : 0;

    try {
        $stmt = $pdo->prepare("UPDATE CATEGORIA SET CATEGORIA_NOME = :nome_categoria, CATEGORIA_DESC = :descricao_categoria, CATEGORIA_ATIVO = :categoria_ativo WHERE CATEGORIA_ID = :categoria_id");
        $stmt->bindParam(':nome_categoria', $nome_categoria, PDO::PARAM_STR);
        $stmt->bindParam(':descricao_categoria', $descricao_categoria, PDO::PARAM_STR);
        $stmt->bindParam(':categoria_ativo', $categoria_ativo, PDO::PARAM_INT);
        $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $stmt->execute();
        header('Location:listar_categoria.php');
        exit();
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao atualizar a categoria: " . $e->getMessage() . "</p>";
    }
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria</title>
</head>

<body>
    <h2>Editar Categoria</h2>
    <form action="./editar_categoria.php" method="POST" enctype="multipart/form-data">
        <input type='hidden' id="categoria_id" name='categoria_id' value="<?php echo $categoria['CATEGORIA_ID']; ?>" />
        <label for="nome_categoria">Nome da categoria: </label>
        <input type="text" id="nome_categoria" name="nome_categoria" value="<?php echo $categoria['CATEGORIA_NOME']; ?>" required>
        <p></p>
        <label for="descricao_categoria">Descrição Categoria: </label>
        <input type="text" id="descricao_categoria" name="descricao_categoria" value="<?php echo $categoria['CATEGORIA_DESC']; ?>" required>
        <p></p>
        <label for="ativo">Ativo</label>
        <input type="checkbox" id="categoria_ativo" name="categoria_ativo" value="1" <?php echo $categoria['CATEGORIA_ATIVO'] ? 'checked' : '' ;?>>
        <p></p>
        <input type="submit" value="Cadastrar">
    </form>
    <a href="listar_categoria.php">Voltar a lista de Categorias</a>


</body>

</html>


