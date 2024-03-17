<?php

session_start(); //inicia a sessão

require_once('conexao.php'); //inclui o arquivo de conexão

$nome = $_POST['nome']; //recebe o nome do formulário
$senha = $_POST['senha'];   //recebe a senha do formulário

$sql = "SELECT * FROM ADMINISTRADOR WHERE ADM_NOME = :nome AND ADM_SENHA = :senha AND ADM_ATIVO = 1"; //consulta SQL

$query = $pdo->prepare($sql); //prepara a consulta SQL

$query->bindParam(':nome', $nome, PDO::PARAM_STR); //substitui o parâmetro :nome pelo valor da variável $nome 
$query->bindParam(':senha', $senha, PDO::PARAM_STR); //substitui o parâmetro :senha pelo valor da variável $senha

$query->execute(); //executa a consulta SQL

if ($query->rowCount() > 0) { //se retornar algum registro
    $_SESSION['admin_logado'] = true; //cria a sessão admin_logado
    header('Location: painel_admin.php'); //redireciona para a página painel_admin.php 
} else {
    header('Location: login.php?erro'); //redireciona para a página login.php com a mensagem de erro
}

?>