<?php

session_start(); //inicia a sessão

if (!isset($_SESSION['admin_logado'])) { //se não existir a sessão admin_logado
    header('Location: ../../pages/login/login.php'); //redireciona para a página login.php
    exit(); //finaliza a execução do script
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $categoria_pesquisada = $_POST['categoria_nome'];

    
    try {
        $stmt = $pdo->prepare("SELECT * FROM CATEGORIA WHERE CATEGORIA.CATEGORIA_NOME LIKE '%' :categoria_pesquisada '%' ");
        $stmt->bindParam(':categoria_pesquisada', $categoria_pesquisada);
        $stmt->execute();
        if ($stmt->rowCount() > 0) { //se retornar algum registro
            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC); //retorna um array associativo com os registros
        } else {
            $categorias = [];
        }
    } catch (PDOException $e) {
        header('Location: ../../pages/categoria/painel_categoria.php?erro_pesquisar');
    }
}
