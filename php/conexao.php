<?php
$host = 'localhost'; //endereço do servidor
$db = 'FOX'; //nome do banco de dados
$user = 'root'; //usuário do banco de dados
$pass = ''; //senha do banco de dados
$charset = 'utf8mb4'; //codificação de caracteres

$dsn = "mysql:host=$host; dbname=$db;charset=$charset"; //monta a string de conexão com o banco de dados

try {
    $pdo = new PDO($dsn, $user, $pass); //cria o objeto de conexão $pdo com o banco de dados
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //configura o modo de erro do objeto de conexão $pdo
    
} catch(PDOException $e) {
    echo "Erro ao tentar conectar com o banco de dados: " . $e->getMessage();
}
?>