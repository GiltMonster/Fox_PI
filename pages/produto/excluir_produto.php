<?php
session_start(); //inicia a sessão
require_once('../../php/config/conexao.php'); //inclui os métodos de conexão do arquivo conexao.php


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['produto_id']; //recebe o id do produto
    if (empty($id)) { //se o id estiver vazio
        echo "<p style='color:red;'>ID do produto não informado!</p>"; //mensagem de erro
        exit(); //finaliza a execução do script
    } else {
        try {
            $stmt = $pdo->prepare("DELETE FROM PRODUTO_ESTOQUE WHERE PRODUTO_ID = :id"); //consulta SQL no banco 
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); //substitui o parâmetro :id pelo valor da variável $id
            $stmt->execute();

            $stmt = $pdo->prepare("DELETE FROM PRODUTO_IMAGEM WHERE PRODUTO_ID = :id"); //consulta SQL no banco 
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); //substitui o parâmetro :id pelo valor da variável $id
            $stmt->execute();

            $stmt = $pdo->prepare("DELETE FROM PRODUTO WHERE PRODUTO_ID = :id"); //consulta SQL no banco 
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); //substitui o parâmetro :id pelo valor da variável $id
            $stmt->execute(); //executa a consulta SQL
            if ($stmt->rowCount() > 0) { //se retornar algum registro
                $produto = $stmt->fetch(PDO::FETCH_ASSOC); //retorna um array associativo com os registros
                header('Location: listar_produto.php'); //redireciona para a página listar_produtos.php
            } else {
                echo "<p style='color:red;'>Produto não encontrado!</p>"; //mensagem de erro
                exit(); //finaliza a execução do script
            }
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Erro ao buscar o produto: " . $e->getMessage() . "</p>"; //mensagem de erro
        }
    }
}
?>
