<?php
    session_start(); //inicia a sessão
    if (!isset($_SESSION['admin_logado'])) { //se não existir a sessão admin_logado
        header('Location:login.php'); //redireciona para a página login.php
        exit(); //finaliza a execução do script
    }

    require_once('../../php/config/conexao.php'); //inclui o arquivo de conexão


    try{
        $stmt = $pdo->prepare("SELECT * FROM CATEGORIA");
        $stmt->execute();
        if ($stmt->rowCount() > 0) { //se retornar algum registro
            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC); //retorna um array associativo com os registros
        } else {
            $categorias = [];
        }
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao listar as Categorias: " . $e . "</p>"; //mensagem de erro
    }

?>


<!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../style/index.css">
        <link rel="icon" href="../../favicon.ico" />
    <title>listar Categoria</title>
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

        <h2>Lista de Categorias</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Ativo</th>
                <th>Excluir</th>
                <th>Editar</th>
            </tr>
            <?php
            foreach ($categorias as $categoria) {
                echo "<tr>";
                echo "<td>" . $categoria['CATEGORIA_ID'] . "</td>";
                echo "<td>" . $categoria['CATEGORIA_NOME'] . "</td>";
                echo "<td>" . $categoria['CATEGORIA_DESC'] . "</td>";
                echo "<td>" . $categoria['CATEGORIA_ATIVO'] . "</td>";
                echo "<td><a href='../../php/categoria/excluir_categoria.php?id=" . $categoria['CATEGORIA_ID'] . "'>Excluir</a></td>";
                echo "<td><a href='./editar_categoria.php?categoria_id=" . $categoria['CATEGORIA_ID'] . "'>Editar</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
        <p><a href="./cadastrar_categoria.php">Cadastrar Categoria</a></p>
    </body>

    </html>