<?php
session_start(); // inicia a sessão
require_once('../config/conexao.php'); // inclui os métodos de conexão do arquivo conexao.php

if (!isset($_SESSION['admin_logado'])) { //se não existir a sessão admin_logado
    header('Location: ../../pages/login/login.php'); //redireciona para a página login.php
    exit(); //finaliza a execução do script
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // se o formulário foi submetido
    $adm_nome = $_POST['adm_nome']; // recebe o nome adm
    $adm_email = $_POST['adm_email']; // recebe email
    $adm_senha = $_POST['adm_senha']; // recebe senha
    $adm_ativo = isset($_POST['adm_ativo']) ? 1 : 0; //recebe informação se esta ativo


    try {
        $sql = "INSERT INTO ADMINISTRADOR (ADM_NOME, ADM_EMAIL, ADM_SENHA, ADM_ATIVO) 
        VALUES (:adm_nome, :adm_email, :adm_senha, :adm_ativo)"; // consulta SQL
        $query = $pdo->prepare($sql); // prepara a consulta SQL
        $query->bindParam(':adm_nome', $adm_nome, PDO::PARAM_STR);
        $query->bindParam(':adm_email', $adm_email, PDO::PARAM_STR);
        $query->bindParam(':adm_senha', $adm_senha, PDO::PARAM_STR);
        $query->bindParam(':adm_ativo', $adm_ativo, PDO::PARAM_STR);

        $query->execute(); // executa a consulta SQL

        //echo "<p style='color:green;'>Produto cadastrado com sucesso!</p>"; // mensagem de sucesso

    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao cadastrar o administrador: " . $e->getMessage() . "</p>"; // mensagem de erro
    }
}
