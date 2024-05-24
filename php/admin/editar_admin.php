<?php
session_start(); //inicia a sessão

if (!isset($_SESSION['admin_logado'])) { //se não existir a sessão admin_logado
    header('Location: ../../pages/login/login.php'); //redireciona para a página login.php
    exit(); //finaliza a execução do script
}

//se a pagina foi acessada via GET e o adm_id foi informado por path param na URL 
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $adm_id = $_GET['adm_id']; //recebe o adm_id do adm
    if (empty($adm_id)) { //se o adm_id estiver vazio
        echo "<p style='color:red;'>adm_id do administrador não informado!</p>"; //mensagem de erro
        exit(); //finaliza a execução do script
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM ADMINISTRADOR WHERE ADM_ID = :adm_id"); //consulta SQL
            $stmt->bindParam(':adm_id', $adm_id, PDO::PARAM_INT); //substitui o parâmetro :adm_id pelo valor da variável $adm_id
            $stmt->execute(); //executa a consulta SQL
            if ($stmt->rowCount() > 0) { //se retornar algum registro
                $administrador = $stmt->fetch(PDO::FETCH_ASSOC); //retorna um array associativo com os registros
                //echo var_dump($administrador); informa o tipo e os valors dos campos a serem trabalhados
            } else {
                echo "<p style='color:red;'>Administrador não encontrado!</p>"; //mensagem de erro
                exit(); //finaliza a execução do script
            }
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Erro ao buscar administrador: " . $e->getMessage() . "</p>"; //mensagem de erro
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //se o formulário foi submetido
    $adm_id = $_POST['adm_id']; //recebe o adm_id do administrador
    $adm_nome = $_POST['adm_nome'];; //recebe o nome do produto
    $adm_email = $_POST['adm_email']; // recebe email
    $adm_senha = $_POST['adm_senha']; // recebe senha
    $adm_ativo = isset($_POST['adm_ativo']) ? 1 : 0; //recebe informação se esta ativo

    $adm_senha = password_hash($adm_senha, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("UPDATE ADMINISTRADOR SET ADM_NOME = :adm_nome, ADM_EMAIL = :adm_email, ADM_SENHA = :adm_senha, ADM_ATIVO = :adm_ativo WHERE ADM_ID = :adm_id");
        $stmt->bindParam(':adm_nome', $adm_nome, PDO::PARAM_STR);
        $stmt->bindParam(':adm_email', $adm_email, PDO::PARAM_STR);
        $stmt->bindParam(':adm_senha', $adm_senha, PDO::PARAM_STR);
        $stmt->bindParam(':adm_ativo', $adm_ativo, PDO::PARAM_INT);
        $stmt->bindParam(':adm_id', $adm_id, PDO::PARAM_INT);
        $stmt->execute();
        header('Location:../../pages/admin/painel_admin.php?editado');
        exit();
    } catch (PDOException $e) {
       header('Location:../../pages/admin/painel_admin.php?erro') ;
    }
}


?>