<?php

session_start(); //inicia a sessão

require_once('../config/conexao.php'); //inclui o arquivo de conexão

$email = $_POST['adm_email']; //recebe o email do formulário
$senha = $_POST['adm_senha'];   //recebe a senha do formulário


$sql = "SELECT * FROM ADMINISTRADOR WHERE ADM_EMAIL = :adm_email"; //consulta SQL
$query = $pdo->prepare($sql); //prepara a consulta SQL
$query->bindParam(':adm_email', $email, PDO::PARAM_STR); //substitui o parâmetro :nome pelo valor da variável $nome 
$query->execute(); //executa a consulta SQL

if ($query->rowCount() > 0) { //se retornar algum registro
    $admin = $query->fetch(PDO::FETCH_ASSOC); //retorna um array associativo com os registros

    if (password_verify($senha, $admin['ADM_SENHA'])) {
        if ($admin['ADM_ATIVO'] == 0) { //se o usuário estiver inativo
            header('Location: ../../pages/login/login.php?ativo'); //redireciona para a página login.php com a mensagem de usuário inativo
        } else {
            $_SESSION['admin_logado'] = $admin; //cria a sessão admin_logado
            header('Location: ../../index.php'); //redireciona para a página painel_admin.php
        }
    } else {
        header('Location: ../../pages/login/login.php?erro'); //redireciona para a página login.php com a mensagem de erro
    }
}
