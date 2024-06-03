<?php
session_start(); //inicia a sessão

//inclui o arquivo de conexão

if (!isset($_SESSION['admin_logado'])) { //se não existir a sessão admin_logado
    header('Location: ../../pages/login/login.php'); //redireciona para a página login.php
    exit(); //finaliza a execução do script
}

try {
    $stmt = $pdo->prepare("SELECT PRODUTO.*, C.CATEGORIA_NOME, PE.PRODUTO_QTD FROM PRODUTO 
    LEFT JOIN CATEGORIA C ON PRODUTO.CATEGORIA_ID = C.CATEGORIA_ID 
    LEFT JOIN PRODUTO_ESTOQUE PE ON PE.PRODUTO_ID = PRODUTO.PRODUTO_ID;
    ");
    $stmt->execute();
    if ($stmt->rowCount() > 0) { //se retornar algum registro
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC); //retorna um array associativo com os registros

        $imagens_produto = [];

        if (isset($produtos)) {
            foreach ($produtos as $produto) {
                $img_smtp = $pdo->prepare("SELECT * FROM PRODUTO_IMAGEM WHERE PRODUTO_ID = :produto_id");
                $img_smtp->bindParam(':produto_id', $produto['PRODUTO_ID']);
                $img_smtp->execute();
                if ($img_smtp->rowCount() > 0) { //se retornar algum registro
                    $imagens_produto[$produto['PRODUTO_ID']] = $img_smtp->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $imagens_produto[$produto['PRODUTO_ID']] = [];
                }
            }
        } else {
            $imagens_produto = [];
        }
    } else {
        $produtos = [];
    }
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao listar os produtos: " . $e . "</p>"; //mensagem de erro
}

?>