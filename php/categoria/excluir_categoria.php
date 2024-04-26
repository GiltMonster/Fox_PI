<?php
session_start(); //inicia a sessão
require_once('../config/conexao.php'); //inclui os métodos de conexão do arquivo conexao.php

// if (!isset($_SESSION['admin_logado'])) { //se não existir a sessão admin_logado
//     header('Location:login.php'); //redireciona para a página login.php
//     exit(); //finaliza a execução do script
// }

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id']; //recebe o id do categoria
    if (empty($id)) { //se o id estiver vazio
        echo "<p style='color:red;'>ID da categoria não informado!</p>"; //mensagem de erro
        exit(); //finaliza a execução do script
    } else {
        try {
            $stmt = $pdo->prepare("DELETE FROM CATEGORIA WHERE CATEGORIA_ID = :id"); //consulta SQL no banco 
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); //substitui o parâmetro :id pelo valor da variável $id
            $stmt->execute(); //executa a consulta SQL
            if ($stmt->rowCount() > 0) { //se retornar algum registro
                $produto = $stmt->fetch(PDO::FETCH_ASSOC); //retorna um array associativo com os registros
                header('Location: ../../pages/categoria/listar_categoria.php'); //redireciona para a página listar_produtos.php
            } else {
                echo "<p style='color:red;'>Categoria não encontrada!</p>"; //mensagem de erro
                exit(); //finaliza a execução do script
            }
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Erro ao buscar a categoria: " . $e->getMessage() . "</p>"; //mensagem de erro
        }
    }
}


?>
