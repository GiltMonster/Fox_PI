<?php

session_start();

if (!isset($_SESSION['admin_logado'])) { //se não existir a sessão admin_logado
    header('Location: ../../pages/login/login.php'); //redireciona para a página login.php
    exit(); //finaliza a execução do script
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //se o formulário foi submetido
    $adm_nome = $_POST['adm_nome']; //recebe o nome do administrador

    
    try {
        $stmt = $pdo->prepare("SELECT * FROM ADMINISTRADOR WHERE ADM_NOME LIKE '%' :adm_nome '%'");
        $stmt->bindParam(':adm_nome', $adm_nome, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) { //se retornar algum registro
            $adms_pesquisados = $stmt->fetchAll(PDO::FETCH_ASSOC); //retorna um array associativo com os registros
        } else {
            $adms_pesquisados = [];
        }
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao pesquisar o administrador: " . $e->getMessage() . "</p>";
    }
}

?>