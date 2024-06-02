<?php
session_start(); //inicia a sessão
require_once('../../php/config/conexao.php'); //inclui os metodos de conexão do arquivo conexao.php

if (!isset($_SESSION['admin_logado'])) { //se não existir a sessão admin_logado
    header('Location: ../../pages/login/login.php'); //redireciona para a página login.php
    exit(); //finaliza a execução do script
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $desconto = $_POST['desconto'];
    $categoria_id = $_POST['categoria_id'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    $imagens = $_FILES['imagem_url'];
    $imagem_ordens = $_POST['imagem_ordem'];
    $produto_qtd = $_POST['produto_qtd'];

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
 var_dump($imagens);
 var_dump($imagem_ordens);

        if (isset($_FILES['imagem_url']['error']) && $_FILES['imagem_url']['error'][0] == 0) {
            //Inserindo imagens no BD
            foreach ($_FILES['imagem_url']['error'] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES['imagem_url']['tmp_name'][$key];
                    $name = basename($_FILES['imagem_url']['name'][$key]);

                    // URL da API do Imgur
                    $api_url = "https://api.imgur.com/3/image";
                    $client_id = '86e6f292245f131'; // Substitua pelo seu Client ID

                    $ch = curl_init($api_url);

                    $image = file_get_contents($tmp_name);
                    if ($image === false) {
                        throw new Exception("Erro: Não foi possível ler o arquivo de imagem.");
                    }

                    $data = array(
                        'image' => base64_encode($image),
                        'type' => 'base64',
                        'name' => $imagem['name'],
                        'title' => $nome,
                        'description' => $descricao,
                    );

                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        "Authorization: Client-ID $client_id"
                    ));

                    $response = curl_exec($ch);
                    $result = json_decode($response, true);

                    if (curl_errno($ch)) {
                        throw new Exception(curl_error($ch));
                    }
                    curl_close($ch);

                    if (isset($result['success']) && $result['success'] === true) {
                        $url_imagem_produtos = $result['data']['link'];
                        try {
                            $ordem = $imagem_ordens[$key];
                            $sql_imagem = "INSERT INTO PRODUTO_IMAGEM(IMAGEM_URL, PRODUTO_ID, IMAGEM_ORDEM ) VALUES (:url_imagem, :produto_id, :ordem_imagem)";
                            $stmt_imagem = $pdo->prepare($sql_imagem);
                            $stmt_imagem->bindParam(':url_imagem', $url_imagem_produtos, PDO::PARAM_STR);
                            $stmt_imagem->bindParam(':produto_id', $produto_id, PDO::PARAM_STR);
                            $stmt_imagem->bindParam(':ordem_imagem', $ordem, PDO::PARAM_INT);
                            $stmt_imagem->execute();
                            header('Location: ../../pages/produto/painel_produtos.php?sucesso');
                        } catch (PDOException $e) {
                            echo 'Erro ao executar as imagens: ' . $e->getMessage();
                            header('Location: ../../pages/produto/painel_produtos.php?erro');
                        }
                    } else {
                        throw new Exception("Erro no upload da imagem: " . json_encode($result));
                        header('Location: ../../pages/produto/painel_produtos.php?erro');
                    }

                } else {
                    // echo 'Erro ao executar as imagens: ' . $e->getMessage();
                    header('Location: ../../pages/produto/painel_produtos.php?erro');
                }
            }
        } else {
            // echo 'Sem imagens para cadastrar!';
            header('Location: ../../pages/produto/painel_produtos.php?sucesso');
        }
    } catch (PDOException $e) {
        header('Location: ../../pages/produto/painel_produtos.php?erro');
        //$e->getMessage();
    }
}
