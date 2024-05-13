<?php
session_start();

if (!isset($_SESSION['admin_logado'])) {
    header('Location: ../../pages/login/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produto_nome = $_POST['produto_nome'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM PRODUTO 
        LEFT JOIN CATEGORIA ON PRODUTO.CATEGORIA_ID = CATEGORIA.CATEGORIA_ID 
        LEFT JOIN PRODUTO_ESTOQUE ON PRODUTO_ESTOQUE.PRODUTO_ID = PRODUTO.PRODUTO_ID WHERE PRODUTO.PRODUTO_NOME LIKE '%' :produto_nome '%'");
        $stmt->bindParam(':produto_nome', $produto_nome, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $prods_pesquisados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $imagens_produto = [];

            if (isset($prods_pesquisados)) {
                foreach ($prods_pesquisados as $produto) {
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
            $prods_pesquisados = [];
        }
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao pesquisar o produto: " . $e->getMessage() . "</p>";
    }
}
