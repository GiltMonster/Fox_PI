<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/admin/painel_admin.css">
    <link rel="stylesheet" href="../../style/index.css">
    <title>Painel administrador</title>
</head>

<body>
    <header class="navbar">
        <h1>Fox brinquedos</h1>
        <nav>
            <ul>
                <li><a href="../../index.php">Home</a></li>
                <li><a href="./painel_admin.php">Administradores</a></li>
                <li><a href="../produto/painel_produtos.php">Produtos</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="container">

            <div class="pesquisa-header">
                <h2>Administrador</h2>

                <form method="POST" class="pesquisa-form">
                    <input type="text" placeholder="Buscar administrador" name="adm_nome" />
                    <button type="submit">
                        <img src="../../images/icons/search.svg" alt="search">
                    </button>


                </form>
                <a class="btn-admin" href="../../pages/admin/cadastrar_administrador.php">
                    <!-- <svg class="feather feather-user-plus" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="8.5" cy="7" r="4" />
                        <line x1="20" x2="20" y1="8" y2="14" />
                        <line x1="23" x2="17" y1="11" y2="11" />
                    </svg> -->
                    <label>
                        Cadastrar administrador
                    </label>
                </a>

            </div>

            <?php
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
                        echo "<td>" . ($adm['ADM_ATIVO']  == 1 ? '<label style="color:green;">Ativo</label>' : '<p style="color:red;">Inativo</p>') . "</td>";
                        echo "<td>
                        <a href='../../php/admin/editar_admin.php?adm_id=" . $adm['ADM_ID'] . "'>Editar</a>
                        <a href='../../php/admin/excluir_administrador.php?id=" . $adm['ADM_ID'] . "'>Excluir</a>
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
                        echo "<td>" . ($adm['ADM_ATIVO']  == 1 ? '<label style="color:green;">Ativo</label>' : '<p style="color:red;">Inativo</p>') . "</td>";
                        echo "<td>
                        <a href='./editar_admin.php?adm_id=" . $adm['ADM_ID'] . "'>Editar</a>
                        <a href='./excluir_administrador.php?id=" . $adm['ADM_ID'] . "'>Excluir</a>
                        </td>";
                        echo "</tr>";
                    }
                    echo '</table>';
                } else {
                    echo "<p>Nenhum administrador encontrado</p>";
                }
            }

            ?>

        </section>
    </main>
</body>

</html>