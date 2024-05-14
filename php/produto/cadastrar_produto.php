<?php
session_start(); //inicia a sessão
require_once('../../php/config/conexao.php'); //inclui os metodos de conexão do arquivo conexao.php

if (!isset($_SESSION['admin_logado'])) { //se não existir a sessão admin_logado
    header('Location: ../../pages/login/login.php'); //redireciona para a página login.php
    exit(); //finaliza a execução do script
}

try {
    $categorias = $pdo->prepare('SELECT * FROM CATEGORIA');
    $categorias->execute(); //executa a query
    $categorias = $categorias->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Erro ao executar a ao pegar a categoria: ' . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $desconto = $_POST['desconto'];
    $categoria_id = $_POST['categoria_id'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    $imagem_urls = $_POST['imagem_url'];
    $imagem_ordens = $_POST['imagem_ordem'];

    $produto_qtd = $_POST['produto_qtd'];

    print_r($_POST);
    try {
        $sql = "INSERT INTO PRODUTO (PRODUTO_NOME, PRODUTO_DESC, PRODUTO_PRECO, PRODUTO_DESCONTO, CATEGORIA_ID, PRODUTO_ATIVO) 
         VALUES (:nome, :descricao, :preco, :desconto, :categoria_id, :ativo)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
        $stmt->bindParam(':desconto', $desconto, PDO::PARAM_STR);
        $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
        $stmt->execute();

        $produto_id = $pdo->lastInsertId();

        try {
            $sql = "INSERT INTO PRODUTO_ESTOQUE (PRODUTO_ID, PRODUTO_QTD) 
            VALUES (:produto_id, :produto_qtd)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_STR);
            $stmt->bindParam(':produto_qtd', $produto_qtd, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Erro ao executar a cadastrar estoque: ' . $e->getMessage();
        }

        if ($imagem_urls) {
            try {
                //Inserindo imagens no BD
                foreach ($imagem_urls as $index => $url) {
                    $ordem = $imagem_ordens[$index];
                    $sql_imagem = "INSERT INTO PRODUTO_IMAGEM(IMAGEM_URL, PRODUTO_ID, IMAGEM_ORDEM ) VALUES (:url_imagem, :produto_id, :ordem_imagem)";
                    $stmt_imagem = $pdo->prepare($sql_imagem);
                    $stmt_imagem->bindParam(':url_imagem', $url, PDO::PARAM_STR);
                    $stmt_imagem->bindParam(':produto_id', $produto_id, PDO::PARAM_STR);
                    $stmt_imagem->bindParam(':ordem_imagem', $ordem, PDO::PARAM_INT);
                    $stmt_imagem->execute();
                }
                header('Location: ../../pages/produto/painel_produtos.php?sucesso');
            } catch (PDOException $th) {
                header('Location: ../../pages/produto/painel_produtos.php?erro');
                //$th->getMessage();
            }
        } else {
            header('Location: ../../pages/produto/painel_produtos.php?sucesso');
        }
    } catch (PDOException $e) {
        header('Location: ../../pages/produto/painel_produtos.php?erro');
        //$e->getMessage();
    }
}
