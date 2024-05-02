<?php
    session_start(); //inicia a sessão

    // require_once('../config/conexao.php'); //inclui o arquivo de conexão

    // if (!isset($_SESSION['admin_logado'])) { //se não existir a sessão admin_logado
    //     header('Location:login.php'); //redireciona para a página login.php
    //     exit(); //finaliza a execução do script
    // }

    try{
        $stmt = $pdo->prepare("SELECT * FROM ADMINISTRADOR");
        $stmt->execute();
        if ($stmt->rowCount() > 0) { //se retornar algum registro
            $adms = $stmt->fetchAll(PDO::FETCH_ASSOC); //retorna um array associativo com os registros
        } else {
            $adms = [];
        }
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao listar os administradores: " . $e . "</p>"; //mensagem de erro
    }

?>