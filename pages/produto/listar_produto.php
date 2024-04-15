<?php
session_start(); //inicia a sessão

require_once('../../php/config/conexao.php'); //inclui o arquivo de conexão

// if (!isset($_SESSION['admin_logado'])) { //se não existir a sessão admin_logado
//     header('Location: ./login.php'); //redireciona para a página login.php
//     exit(); //finaliza a execução do script
// }

try {
    $stmt = $pdo->prepare("SELECT PRODUTO.*, PRODUTO_IMAGEM.*, CATEGORIA.CATEGORIA_NOME FROM PRODUTO INNER 
    JOIN PRODUTO_IMAGEM ON PRODUTO.PRODUTO_ID = PRODUTO_IMAGEM.PRODUTO_ID 
    LEFT JOIN CATEGORIA ON PRODUTO.CATEGORIA_ID = CATEGORIA.CATEGORIA_ID;
    ");
    $stmt->execute();
    if ($stmt->rowCount() > 0) { //se retornar algum registro
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC); //retorna um array associativo com os registros
        // echo var_dump($produtos);
    } else {
        $produtos = [];
    }
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao listar os produtos: " . $e . "</p>"; //mensagem de erro
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/index.css">
    <title>Produtos</title>
</head>

<body>
    <header class="navbar">
        <h1>Fox brinquedos</h1>
        <nav>
            <ul>
                <li><a href="../../index.php">Home</a></li>
                <li><a href="./painel_admin.php">Administradores</a></li>
                <li><a href="./painel_produtos.php">Produtos</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="container">
            <h2>Seja bem-vindo!</h2>
            <p>Este é um site de exemplo de PHP com mySQL, aqui você pode ver os produtos existentes.</p>
            <div id="listaProdutos">

                <h2>Lista de Produtos</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th>Descrição</th>
                            <th>Categoria</th>
                            <th>Ativo</th>
                            <th>Desconto</th>
                            <th>Imagem</th>
                            <th>Ações</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        // Itera sobre os produtos para exibi-los na tabela
                        foreach ($produtos as $produto) : ?>
                            <tr>
                                <td>
                                    <?php echo $produto['PRODUTO_NOME']; ?>
                                </td>
                                <td>
                                    <?php echo $produto['PRODUTO_PRECO']; ?>
                                </td>
                                <td>
                                    <?php echo $produto['PRODUTO_DESC']; ?>
                                </td>
                                <td>
                                    <?php echo $produto['CATEGORIA_NOME']; ?>
                                </td>
                                <td>
                                    <?php echo $produto['PRODUTO_ATIVO'] == 1 ? '<p style="color:green;">Ativo</p>' : '<p style="color:red;">Inativo</p>'; ?>
                                </td>
                                <td>
                                    <?php
                                    echo $produto['PRODUTO_DESCONTO'];
                                    $produto['PRODUTO_DESCONTO'] != 0 ? "R$ " . number_format($valor, 2, ',', '.') . " R$" . number_format($produto['PRODUTO_PRECO'], 2, ',', '.') . "-" .  number_format($produto['PRODUTO_DESCONTO'], 2, ',', '.') :  "R$ " . number_format($produto['PRODUTO_PRECO'], 2, ',', '.')
                                    ?>
                                </td>
                                <td>
                                    <img src="<?php echo $produto['IMAGEM_URL']; ?>" alt="<?php echo $produto['PRODUTO_NOME']; ?>" style="width: 100px;">
                                </td>

                                <td><a href='<?php "../../php/produto/excluir_produto.php?id=" . $produto['ID_PRODUTO'] ?>'>Excluir</a></td>
                                <td><a href='<?php "./pages/editar_produto.php?id=" . $produto['ID_PRODUTO'] ?>'>Editar</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </section>
</body>

</html>