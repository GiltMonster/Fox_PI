<?php
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../login/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/admin/painel_admin.css">
    <link rel="stylesheet" href="../../style/index.css">
    <link rel="stylesheet" href="../../style/alerts.css">
    <link rel="icon" href="../../favicon.ico" />
    <title>Painel administrador</title>
</head>

<body>
    <header class="navbar">
        <div>
            <img src="../../images/fox.svg" alt="fox logo" />
            <nav>
                <ul>
                    <li><a href="../../index.php">Home</a></li>
                    <li><a href="./painel_admin.php">Administradores</a></li>
                    <li><a href="../produto/painel_produtos.php">Produtos</a></li>
                </ul>
            </nav>
        </div>

        <a class="btn-sair" href="./painel_admin.php?logout">Sair</a>
    </header>

    <main>
        <section class="container">

            <div class="pesquisa-header">
                <h2>Administrador</h2>

                <form method="POST" class="pesquisa-form">
                    <input type="text" placeholder="Buscar administrador" name="adm_nome" required />
                    <button type="submit">
                        <img src="../../images/icons/search.svg" alt="search">
                    </button>


                </form>
                <a class="btn-admin" href="../../pages/admin/cadastrar_administrador.php">
                    <label>
                        Cadastrar administrador
                    </label>
                </a>

            </div>
            <?php
            if (isset($_GET['sucesso'])) {
                echo '
                <div class="alert alert-success">
                    <span class="closebtn">&times;</span>
                    <strong>Sucesso!</strong> Administrador cadastrado com sucesso.
                </div>
                ';
            } elseif (isset($_GET['excluido'])) {
                echo '
                <div class="alert alert-success">
                    <span class="closebtn">&times;</span>
                    Sucesso administrador <strong>excluído</strong> com sucesso.
                </div>
                ';
            } elseif (isset($_GET['erro'])) {
                echo '
                <div class="alert alert-danger">
                    <span class="closebtn">&times;</span>
                    <strong>Erro!</strong> Ocorreu um erro ao excluir o administrador.
                </div>
                    ';
            } elseif (isset($_GET['editado'])) {
                echo '
                <div class="alert alert-info">
                    <span class="closebtn">&times;</span>
                    <strong>Sucesso!</strong> Administrador editado com sucesso.
                </div>
                ';
            } elseif (isset($_GET['erro_editar'])) {
                echo '
                <div class="alert alert-danger">
                    <span class="closebtn">&times;</span>
                    <strong>Erro!</strong> Ocorreu um erro ao editar o administrador.
                </div>
                ';
            }elseif (isset($_GET['erro_pesquisa'])) {
                echo '
                <div class="alert alert-danger">
                    <span class="closebtn">&times;</span>
                    <strong>Erro!</strong> Ocorreu um erro ao pesquisar o administrador.
                </div>
                ';
            }elseif (isset($_GET['op_excluir'])) {
                echo '
                <div class="alert alert-danger">
                    <span class="closebtn">&times;</span>
                    <strong>Erro!</strong> Operação de exclusão em desenvolvimento.
                </div>
                ';
            }

            require_once('../../php/config/conexao.php');

            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                include '../../php/admin/listar_administrador.php';
                if ($adms) {
                    echo '
                    <table>
                    <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Nome</th>
                    <th>Senha</th>
                    <th>Ativo</th>
                    <th>Alterações</th>
                    </tr>
                    ';
                    foreach ($adms as $adm) {
                        echo "<tr>";
                        echo "<td>" . $adm['ADM_ID'] . "</td>";
                        echo "<td>" . $adm['ADM_EMAIL'] . "</td>";
                        echo "<td>" . $adm['ADM_NOME'] . "</td>";
                        echo "<td>" . $adm['ADM_SENHA'] . "</td>";
                        echo "<td>" . ($adm['ADM_ATIVO']  == 1 ? '<label style="color:green;">Ativo</label>' : '<label style="color:red;">Inativo</label>') . "</td>";
                        echo "<td>
                        <a href='./editar_admin.php?adm_id=" . $adm['ADM_ID'] . "'>
                            <img class='editar' src='../../images/icons/editar.svg' alt='editar'/>
                        </a>
                        <a href='./painel_admin.php?op_excluir'>
                            <img class='excluir' src='../../images/icons/excluir.svg' alt='excluir'/>
                        </a>
                        </td>";
                        echo "</tr>";
                    }
                    echo '</table>';
                }
            } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                include '../../php/admin/pesquisar_admin.php';
                if ($adms_pesquisados) {
                    echo '
                    <div class="pesquisa-header">
                    <h3>Administrador pesquisado: <label style="color:#f9a80c">' . $_POST['adm_nome'] . '</label></h3>
                    <a class="btn-limpa-pesquisa" href="./painel_admin.php">Limpar pesquisa</a>
                    </div>

                    <table>
                    <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Nome</th>
                    <th>Senha</th>
                    <th>Ativo</th>
                    <th>Alterações</th>
                    </tr>
                    ';
                    foreach ($adms_pesquisados as $adm) {
                        echo "<tr>";
                        echo "<td>" . $adm['ADM_ID'] . "</td>";
                        echo "<td>" . $adm['ADM_EMAIL'] . "</td>";
                        echo "<td>" . $adm['ADM_NOME'] . "</td>";
                        echo "<td>" . $adm['ADM_SENHA'] . "</td>";
                        echo "<td>" . ($adm['ADM_ATIVO']  == 1 ? '<label style="color:green;">Ativo</label>' : '<label style="color:red;">Inativo</label>') . "</td>";
                        echo "<td>
                        <a href='./editar_admin.php?adm_id=" . $adm['ADM_ID'] . "'>
                            <img class='editar' src='../../images/icons/editar.svg' alt='editar'/>
                        </a>
                        <a href='./painel_admin.php?op_excluir'>
                            <img class='excluir' src='../../images/icons/excluir.svg' alt='excluir'/>
                        </a>
                        </td>";
                        echo "</tr>";
                    }
                    echo '</table>';
                } else {
                    echo '<div class="pesquisa-header">
                    <h3>Administrador pesquisado: <label style="color:#f9a80c">' . $_POST['adm_nome'] . '</label></h3>
                    <a class="btn-limpa-pesquisa" href="./painel_admin.php">Limpar pesquisa</a>
                    </div>
                    ';
                    echo "
                    <div class='notes danger'>
                        <p>Nenhum administrador encontrado</p>
                    </div>
                    ";
                }
            }

            ?>

        </section>
    </main>
</body>
<script src="../../js/alerts.js"></script>

</html>