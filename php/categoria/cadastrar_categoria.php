<?php
    session_start(); //inicia a sessão
    require_once('../config/conexao.php'); //inclui os metodos de conexão do arquivo conexao.php
    
    if (!isset($_SESSION['admin_logado'])) { //se não existir a sessão admin_logado
         header('Location: ../../pages/login/login.php'); //redireciona para a página login.php
         exit(); //finaliza a execução do script
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $categoria_ativo = isset($_POST['categoria_ativo']) ? 1 : 0;
        
        try {
            $sql = "INSERT INTO CATEGORIA (CATEGORIA_NOME, CATEGORIA_DESC, CATEGORIA_ATIVO) 
             VALUES (:nome, :descricao, :categoria_ativo)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
            $stmt->bindParam(':categoria_ativo', $categoria_ativo, PDO::PARAM_INT);
            $stmt->execute();
            header('Location: ../../pages/categoria/painel_categoria.php?sucesso');
            
        } catch (PDOException $e) {
            header('Location: ../../pages/categoria/painel_categoria.php?erro');
            
        }
    }
?>