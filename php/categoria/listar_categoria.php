<?php

session_start(); //inicia a sessão
require_once('../../php/config/conexao.php'); //inclui os metodos de conexão do arquivo conexao.php

if (!isset($_SESSION['admin_logado'])) { //se não existir a sessão admin_logado
    header('Location: ../../pages/login/login.php'); //redireciona para a página login.php
    exit(); //finaliza a execução do script
}

try{
    $stmt = $pdo->prepare("SELECT * FROM CATEGORIA");
    $stmt->execute();
    if ($stmt->rowCount() > 0) { //se retornar algum registro
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC); //retorna um array associativo com os registros
    } else {
        $categorias = [];
    }
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao listar as Categorias: " . $e . "</p>"; //mensagem de erro
}

?>