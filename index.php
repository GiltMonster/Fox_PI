<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/index.css">
    <title>Produtos</title>
</head>

<body>
    <header class="navbar">
        <h1>Fox brinquedos</h1>
        <nav>
            <ul>
                <li><a href="./index.php">Home</a></li>
                <li><a href="./pages/admin/painel_admin.php">Administradores</a></li>
                <li><a href="./pages/produto/painel_produtos.php">Produtos</a></li>
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
                            <th>Editar</th>
                            <th>Excluir</th>
                            <th>Ativo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Inclui o arquivo de listagem de produtos
                        require_once './php/config/conexao.php';
                        include './php/produto/listar_produto.php';

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
                                    <?php echo $produto['PRODUTO_ATIVO'] == 1 ? '<p style="color:green;">Ativo</p>' : '<p style="color:red;">Inativo</p>'; ?> 
                                </td>

                                <td><a href='<?php "./php/excluir_produto.php?id=" . $produto['ID_PRODUTO'] ?>'>Excluir</a></td>
                                <td><a href='<?php "./pages/editar_produto.php?id=" . $produto['ID_PRODUTO'] ?>'>Editar</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </section>
</body>

</html>