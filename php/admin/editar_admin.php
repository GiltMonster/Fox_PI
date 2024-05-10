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

    try {
        $stmt = $pdo->prepare("UPDATE ADMINISTRADOR SET ADM_NOME = :adm_nome, ADM_EMAIL = :adm_email, ADM_SENHA = :adm_senha, ADM_ATIVO = :adm_ativo WHERE ADM_ID = :adm_id");
        $stmt->bindParam(':adm_nome', $adm_nome, PDO::PARAM_STR);
        $stmt->bindParam(':adm_email', $adm_email, PDO::PARAM_STR);
        $stmt->bindParam(':adm_senha', $adm_senha, PDO::PARAM_STR);
        $stmt->bindParam(':adm_ativo', $adm_ativo, PDO::PARAM_INT);
        $stmt->bindParam(':adm_id', $adm_id, PDO::PARAM_INT);
        $stmt->execute();
        header('Location:../../pages/admin/painel_admin.php');
        exit();
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao atualizar o administrador: " . $e->getMessage() . "</p>";
    }
}


?>
<a href="../../pages/admin/painel_admin.php"></a>

<!-- <!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar produto</title>
</head>

<body>
    <h2>Editar Produto</h2>
    <form action="./editar_admin.php" method="POST" enctype="multipart/form-data">
        <input type='hidden' id="adm_id" name='adm_id' value="<?php //echo $administrador['ADM_ID']; ?>" />
        <label for="adm_nome">Nome do administrador: </label>
        <input type="text" id="adm_nome" name="adm_nome" value="<?php //echo $administrador['ADM_NOME']; ?>" required>
        <p></p>
        <label for="adm_email">E-mail Admnistrador: </label>
        <input type="text" id="adm_email" name="adm_email" value="<?php //echo $administrador['ADM_EMAIL']; ?>" required>
        <p></p>
        <label for="adm_senha">Senha administrador: </label>
        <input type="password" minlenght="8" id="adm_senha" name="adm_senha" value="<?php //echo $administrador['ADM_SENHA']; ?>" required>
        <p></p>
        <label for="adm_ativo">Ativo</label>
        <input type="checkbox" name="adm_ativo" id="adm_ativo" value="1" <?php //echo $administrador['ADM_ATIVO'] ? 'checked' : '' ;?>>
        <p></p>
        <input type="submit" value="Cadastrar">
    </form>
    <a href="listar_administrador.php">Voltar a lista de Administradores</a>


</body>

</html> -->