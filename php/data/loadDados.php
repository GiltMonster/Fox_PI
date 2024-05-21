<?php

session_start();

if (!isset($_SESSION['admin_logado'])) {
    header('Location: ../../pages/login/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM PRODUTO;");
        $stmt->execute();
        $qtd_produtos = $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo "Erro ao pegar a quantidade de produtos cadastrados";
    }

    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM PRODUTO WHERE PRODUTO.PRODUTO_ATIVO = 1");
        $stmt->execute();
        $qtd_produtos_ativos = $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo "Erro ao selecionar os produtos ativos";
    }

    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM PRODUTO WHERE PRODUTO.PRODUTO_ATIVO = 0");
        $stmt->execute();
        $qtd_produtos_desativados = $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo "Erro ao selecionar os produtos desativados";
    }

    try {
        $stmt = $pdo->prepare("SELECT SUM(PRODUTO_ESTOQUE.PRODUTO_QTD) FROM PRODUTO_ESTOQUE;");
        $stmt->execute();
        $total_produtos_estoque = $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo "Erro ao selecionar o total de produtos em estoque";
    }

    // Dados das categorias

    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM CATEGORIA;");
        $stmt->execute();
        $qtd_categorias = $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo "Erro ao selecionar a quantidade de categorias cadastradas";
    }

    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM CATEGORIA WHERE CATEGORIA.CATEGORIA_ATIVO = 1;");
        $stmt->execute();
        $qtd_categorias_ativas = $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo "Erro ao selecionar as categorias ativas";
    }

    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM CATEGORIA WHERE CATEGORIA.CATEGORIA_ATIVO = 0");
        $stmt->execute();
        $qtd_categorias_desativadas = $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo "Erro ao selecionar as categorias desativadas";
    }

    try {
        $stmt = $pdo->prepare("SELECT CATEGORIA.CATEGORIA_NOME, COUNT(PRODUTO.PRODUTO_ID) FROM PRODUTO JOIN CATEGORIA ON CATEGORIA.CATEGORIA_ID = PRODUTO.CATEGORIA_ID GROUP BY CATEGORIA.CATEGORIA_NOME ORDER BY COUNT(PRODUTO.PRODUTO_ID) DESC LIMIT 5");
        $stmt->execute();
        $categorias_mais_usadas = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo "Erro ao selecionar as categorias mais usadas";
    }
}
