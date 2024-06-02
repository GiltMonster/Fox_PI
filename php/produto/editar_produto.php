<?php

session_start(); //inicia a sessão

require_once('../../php/config/conexao.php'); //inclui o arquivo de conexão

if (!isset($_SESSION['admin_logado'])) { //se não existir a sessão admin_logado
    header('Location: ../../pages/login/login.php'); //redireciona para a página login.php
    exit(); //finaliza a execução do script
}

$imagens_produto = [];
$produto_id = $_GET['produto_id'];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (empty($produto_id)) {
        echo "<p style='color:red;'>Produto não informado!</p>";
        exit();
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM PRODUTO
            LEFT JOIN CATEGORIA ON PRODUTO.CATEGORIA_ID = CATEGORIA.CATEGORIA_ID
            LEFT JOIN PRODUTO_ESTOQUE ON PRODUTO_ESTOQUE.PRODUTO_ID = PRODUTO.PRODUTO_ID
            WHERE PRODUTO.PRODUTO_ID = :produto_id;");
            $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) { //se retornar algum registro
                $produto = $stmt->fetch(PDO::FETCH_ASSOC); //retorna um array associativo com os registros

                if (isset($produto)) {
                    $img_smtp = $pdo->prepare("SELECT * FROM PRODUTO_IMAGEM WHERE PRODUTO_ID = :produto_id");
                    $img_smtp->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
                    $img_smtp->execute();
                    if ($img_smtp->rowCount() > 0) { //se retornar algum registro
                        $imagens_produto = $img_smtp->fetchAll(PDO::FETCH_ASSOC);
                    } else {
                        $imagens_produto = [];
                    }
                }
            } else {
                echo "<p style='color:red;'>Produto não encontrado!</p>";
                exit();
            }
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Erro ao listar os produtos: " . $e . "</p>"; //mensagem de erro
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $desconto = $_POST['desconto'];
    $produto_qtd = $_POST['produto_qtd'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    $categoria_id = $_POST['categoria_id'];
    $imagens = $_FILES['imagem_url'];
    $imagem_ordens = $_POST['imagem_ordem'];

    try {
        $sql = "UPDATE PRODUTO SET PRODUTO_NOME = :nome, PRODUTO_DESC = :descricao, PRODUTO_PRECO = :preco, PRODUTO_DESCONTO = :desconto, CATEGORIA_ID = :categoria_id, PRODUTO_ATIVO = :ativo 
        WHERE PRODUTO_ID = :produto_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
        $stmt->bindParam(':desconto', $desconto, PDO::PARAM_STR);
        $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
        $stmt->execute();

        try {
            $sql = "UPDATE PRODUTO_ESTOQUE SET PRODUTO_QTD = :produto_qtd WHERE PRODUTO_ID = :produto_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
            $stmt->bindParam(':produto_qtd', $produto_qtd, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Erro ao atualizar estoque: ' . $e->getMessage();
        }

        try {
            $img_smtp = $pdo->prepare("SELECT * FROM PRODUTO_IMAGEM WHERE PRODUTO_ID = :produto_id");
            $img_smtp->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
            $img_smtp->execute();
            if ($img_smtp->rowCount() > 0) { //se retornar algum registro
                $imagens_produto = $img_smtp->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $imagens_produto = [];
            }
        } catch (PDOException $e) {
            echo 'Erro ao pegar a imagem: ' . $e->getMessage();
        }
        if ($imagens) {
            try {
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
                                $sql_imagem = "UPDATE PRODUTO_IMAGEM SET IMAGEM_URL = :url_imagem, IMAGEM_ORDEM = :ordem_imagem WHERE IMAGEM_ID = :produto_id";
                                $stmt_imagem = $pdo->prepare($sql_imagem);
                                $stmt_imagem->bindParam(':url_imagem', $url_imagem_produtos, PDO::PARAM_STR);
                                $stmt_imagem->bindParam(':ordem_imagem', $ordem, PDO::PARAM_INT);
                                $stmt_imagem->bindParam(':produto_id', $imagens_produto[$key]['IMAGEM_ID'], PDO::PARAM_INT);
                                $stmt_imagem->execute();

                                header('Location: ../../pages/produto/painel_produtos.php?editado');
                            } catch (PDOException $e) {
                                header('Location: ../../pages/produto/painel_produtos.php?erro');
                            }
                        } else {
                            header('Location: ../../pages/produto/painel_produtos.php?erro');
                            // throw new Exception("Erro no upload da imagem: " . json_encode($result));
                        }
                    } else {
                        header('Location: ../../pages/produto/painel_produtos.php?erro');
                        // echo 'Erro ao executar as imagens: ' . $e->getMessage();
                    }
                }
            } catch (PDOException $th) {
                header('Location: ../../pages/produto/painel_produtos.php?erro');
                echo 'Erro ao executar a atualizar imagem: ' . $th->getMessage();
            }
        }
        header('Location: ../../pages/produto/painel_produtos.php?editado');
    } catch (PDOException $e) {
        echo 'Erro ao executar a atualizar produto: ' . $e->getMessage();
    }
}
