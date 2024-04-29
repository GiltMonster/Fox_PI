<?php
// session_start(); //inicia a sessão

// require_once('../../php/config/conexao.php'); //inclui o arquivo de conexão

// // if (!isset($_SESSION['admin_logado'])) { //se não existir a sessão admin_logado
// //     header('Location: ./login.php'); //redireciona para a página login.php
// //     exit(); //finaliza a execução do script
// // }

// try {
//     $stmt = $pdo->prepare("SELECT * FROM PRODUTO 
//     LEFT JOIN CATEGORIA ON PRODUTO.CATEGORIA_ID = CATEGORIA.CATEGORIA_ID 
//     LEFT JOIN PRODUTO_ESTOQUE ON PRODUTO_ESTOQUE.PRODUTO_ID = PRODUTO.PRODUTO_ID;
//     ");
//     $stmt->execute();
//     if ($stmt->rowCount() > 0) { //se retornar algum registro
//         $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC); //retorna um array associativo com os registros

//         $imagens_produto = [];

//         if (isset($produtos)) {
//             foreach ($produtos as $produto) {
//                 $img_smtp = $pdo->prepare("SELECT * FROM PRODUTO_IMAGEM WHERE PRODUTO_ID = :produto_id");
//                 $img_smtp->bindParam(':produto_id', $produto['PRODUTO_ID']);
//                 $img_smtp->execute();
//                 if ($img_smtp->rowCount() > 0) { //se retornar algum registro
//                     $imagens_produto[$produto['PRODUTO_ID']] = $img_smtp->fetchAll(PDO::FETCH_ASSOC);
//                 } else {
//                     $imagens_produto[$produto['PRODUTO_ID']] = [];
//                 }
//             }
//         } else {
//             $imagens_produto = [];
//         }
//     } else {
//         $produtos = [];
//     }                                    
// } catch (PDOException $e) {
//     echo "<p style='color:red;'>Erro ao listar os produtos: " . $e . "</p>"; //mensagem de erro
// }

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
                <li><a href="../admin/painel_admin.php">Administradores</a></li>
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
                            <th>Estoque</th>
                            <th>Ações</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once('../../php/config/conexao.php');
                        include '../../php/produto/listar_produto.php';

                        // Itera sobre os produtos para exibi-los na tabela
                        foreach ($produtos as $produto) :
                        ?>
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
                                    
                                    if (isset($produto['PRODUTO_DESCONTO']) && $produto['PRODUTO_DESCONTO'] < 100) {
                                        echo '<p style="text-decoration: line-through;">R$ ' . number_format($produto['PRODUTO_PRECO'] - ($produto['PRODUTO_PRECO'] / 100 * $produto['PRODUTO_DESCONTO']), 2, ',', '.') . " </p>(Desconto de " . number_format($produto['PRODUTO_PRECO'] / 100 * $produto['PRODUTO_DESCONTO']) . "%)";
                                    }else{
                                        echo "R$ " . number_format($produto['PRODUTO_PRECO'], 2, ',', '.');
                                    };
                                    ?>
                                </td>
                                <td>
                                    <?php if (isset($imagens_produto[$produto['PRODUTO_ID']]) && !empty($imagens_produto[$produto['PRODUTO_ID']])) : ?>
                                        <?php foreach ($imagens_produto[$produto['PRODUTO_ID']] as $imagem) : ?>
                                            <img src="<?php echo $imagem['IMAGEM_URL']; ?>" alt="<?php echo $produto['PRODUTO_NOME'];?>" style="width: 100px;"> <!-- Substitua 'caminho_da_imagem' pelo nome correto da coluna no seu banco de dados -->
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <p>Nenhuma imagem disponível.</p>
                                    <?php endif; ?>
                                    <!-- <img src="<?php echo $produto['IMAGEM_URL']; ?>" alt="<?php echo $produto['PRODUTO_NOME']; ?>" style="width: 100px;"> -->
                                </td>
                                <td>
                                    <?php echo $produto['PRODUTO_QTD']; ?>
                                </td>

                                <td><a href='<?php echo "./excluir_produto.php?produto_id=" . $produto['PRODUTO_ID'] ?>'>Excluir</a></td>
                                <td><a href='<?php echo "./editar_produto.php?produto_id=" . $produto['PRODUTO_ID'] ?>'>Editar</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </section>
</body>

</html>