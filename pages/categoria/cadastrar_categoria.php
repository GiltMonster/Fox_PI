<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/index.css">
    <title>Cadastrar Categoria</title>
</head>

<body>
    <header class="navbar">
        <h1>Fox brinquedos</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="./cadastrar_categoria.php">Cadastro de produtos</a></li>
                <li><a href="./listar_categoria.php">Listar categorias</a></li>
            </ul>
        </nav>
    </header>

    <h2>Cadastrar Categoria</h2>
    <form action="../../php/categoria/cadastrar_categoria.php" method="post" enctype="multipart/form-data">
        <label for="nome">Nome da categoria:</label>
        <input type="text" id="nome" name="nome" required>
        <p></p>
        <label for="descricao">Descrição da categoria:</label>
        <textarea type="text" id="descricao" name="descricao" required></textarea>
        <p></p>
        <label for="ativo">Categoria ativa:</label>
        <input type="checkbox" id="categoria_ativo" name="categoria_ativo" value="1" checked>
        <p></p>
        <input type="submit" value="Cadastrar">
        <?php
            if (isset($_GET['sucesso'])) { //sucesso é um parâmetro que é passado na URL
            echo '<p class="msg-sucesso">Categoria cadastrada com sucesso!</p>';
            }
        ?>
    </form>
</body>
</html>