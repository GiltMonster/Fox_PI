<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel categoria.</title>
    <link rel="stylesheet" href="../../style/index.css">
    <link rel="stylesheet" href="../../style/categoria/painel_categoria.css">
    <link rel="stylesheet" href="../../style/alerts.css">
</head>

<body>

    <body>
        <header class="navbar">
            <div>
                <img src="../../images/fox.svg" alt="fox logo" />
                <nav>
                    <ul>
                        <li><a href="../../index.php">Home</a></li>
                        <li><a href="../../pages/admin/painel_admin.php">Administradores</a></li>
                        <li><a href="../../pages/produto/painel_produtos.php">Produtos</a></li>
                    </ul>
                </nav>
            </div>

            <a class="btn-sair" href="./painel_categoria.php?logout">Sair</a>
        </header>
        <main>
            <section class="container">

                <div class="pesquisa-header">
                    <h2>Categorias</h2>

                    <form method="POST" class="pesquisa-form">
                        <input type="text" placeholder="Buscar categoria" name="categoria_nome" required />
                        <button type="submit">
                            <img src="../../images/icons/search.svg" alt="search">
                        </button>

                    </form>

                    <a class="btn-categoria" href="./cadastrar_categoria.php">
                        <label>
                            Cadastrar categoria
                        </label>
                    </a>
                </div>

                <?php
                if (isset($_GET['sucesso'])) {
                    echo '<div class="alert alert-success">
                    <span class="closebtn">&times;</span>  
                    <strong>Sucesso!</strong> Categoria cadastrada com sucesso.
                  </div>';
                } else if (isset($_GET['erro'])) {
                    echo '<div class="alert alert-danger">
                    <span class="closebtn">&times;</span>  
                    <strong>Erro!</strong> Não foi possível cadastrar a categoria.
                  </div>';
                } else if (isset($_GET['excluido'])) {
                    echo '<div class="alert alert-success">
                    <span class="closebtn">&times;</span>  
                    <strong>Sucesso!</strong> Categoria excluída com sucesso.
                  </div>';
                } else if (isset($_GET['erro_excluir'])) {
                    echo '<div class="alert alert-danger">
                    <span class="closebtn">&times;</span>  
                    <strong>Erro!</strong> Não foi possível excluir a categoria.
                  </div>';
                } else if (isset($_GET['editado'])) {
                    echo '<div class="alert alert-info">
                    <span class="closebtn">&times;</span>  
                    <strong>Sucesso!</strong> Categoria editada com sucesso.
                  </div>';
                } else if (isset($_GET['erro_editar'])) {
                    echo '<div class="alert alert-danger">
                    <span class="closebtn">&times;</span>  
                    <strong>Erro!</strong> Não foi possível editar a categoria.
                  </div>';
                } else if (isset($_GET['erro_pesquisar'])) {
                    echo '<div class="alert alert-danger">
                    <span class="closebtn">&times;</span>  
                    <strong>Erro!</strong> Não foi possível pesquisar a categoria.
                  </div>';
                }

                ?>

                <?php

                require_once('../../php/config/conexao.php');

                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    include '../../php/categoria/listar_categoria.php';
                    if ($categorias) {
                        echo '
                        <table>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Ativo</th>
                            <th>Alterações</th>
                        </tr>
                        ';
                        foreach ($categorias as $categoria) {
                            echo "<tr>";
                            echo "<td>" . $categoria['CATEGORIA_ID'] . "</td>";
                            echo "<td>" . $categoria['CATEGORIA_NOME'] . "</td>";
                            echo "<td>" . $categoria['CATEGORIA_DESC'] . "</td>";
                            echo "<td>" . ($categoria['CATEGORIA_ATIVO'] == 1 ? '<label style="color:green;">Ativo</label>' : '<label style="color:red;">Inativo</label>') . "</td>";
                            echo "<td>
                            <a href='./editar_categoria.php?categoria_id=" . $categoria['CATEGORIA_ID'] . "'>
                                <img src='../../images/icons/editar.svg' alt='editar'>
                            </a>
                            <a href='../../php/categoria/excluir_categoria.php?categoria_id=" . $categoria['CATEGORIA_ID'] . "'>
                                <img src='../../images/icons/excluir.svg' alt='deletar'>
                            </a>
                            </td>";
                            echo "</tr>";
                        }
                        echo '</table>';
                    } else {
                        echo '<p>Nenhuma categoria cadastrada.</p>';
                    }
                } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    include '../../php/categoria/pesquisar_categoria.php';

                    if ($categorias) {
                        echo '

                    <div class="pesquisa-header">

                    <h3>Categoria pesquisada: <label style="color:#f9a80c">' . $_POST['categoria_nome'] . '</label></h3>
                    <a class="btn-limpa-pesquisa" href="./painel_categoria.php">Limpar pesquisa</a>
                    </div>

                        <table>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Ativo</th>
                            <th>Alterações</th>
                        </tr>
                        ';
                        foreach ($categorias as $categoria) {
                            echo "<tr>";
                            echo "<td>" . $categoria['CATEGORIA_ID'] . "</td>";
                            echo "<td>" . $categoria['CATEGORIA_NOME'] . "</td>";
                            echo "<td>" . $categoria['CATEGORIA_DESC'] . "</td>";
                            echo "<td>" . ($categoria['CATEGORIA_ATIVO'] == 1 ? '<label style="color:green;">Ativo</label>' : '<label style="color:red;">Inativo</label>') . "</td>";
                            echo "<td>
                            <a href='./editar_categoria.php?categoria_id=" . $categoria['CATEGORIA_ID'] . "'>
                                <img src='../../images/icons/editar.svg' alt='editar'>
                            </a>
                            <a href='../../php/categoria/excluir_categoria.php?categoria_id=" . $categoria['CATEGORIA_ID'] . "'>
                                <img src='../../images/icons/excluir.svg' alt='deletar'>
                            </a>
                            </td>";
                            echo "</tr>";
                        }
                        echo '</table>';
                    } else {
                        echo '<p>Nenhuma categoria encontrada.</p>';
                    }
                }

                ?>
            </section>
        </main>

    </body>

    <script src="../../js/alerts.js"></script>

</html>