<?php
session_start(); //inicia a sessão

require_once('conexao.php'); //inclui o arquivo de conexão

// if (!isset($_SESSION['admin_logado'])) { //se não existir a sessão admin_logado
//     header('Location: ./login.php'); //redireciona para a página login.php
//     exit(); //finaliza a execução do script
// }

try {
    $stmt = $pdo->prepare("SELECT * FROM Produtos");
    $stmt->execute();
    if ($stmt->rowCount() > 0) { //se retornar algum registro
        return $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC); //retorna um array associativo com os registros
    } else {
        $produtos = [];
    }
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao listar os produtos: " . $e . "</p>"; //mensagem de erro
}
