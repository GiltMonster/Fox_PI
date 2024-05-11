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
        } else {
            $prods_pesquisados = [];
        }
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao pesquisar o produto: " . $e->getMessage() . "</p>";
    }
}
