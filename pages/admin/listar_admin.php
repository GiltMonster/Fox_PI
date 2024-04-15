<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Administradores</title>
</head>

<body>
    <h2>Lista de Administradores</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Senha</th>
            <th>Ativo</th>
            <th>Excluir</th>
            <th>Editar</th>
        </tr>
        <?php

        // require_once('../../php/admin/listar_administrador.php'); // Use require_once aqui

        // foreach ($adms as $adm) {
        //     echo "<tr>";
        //     echo "<td>" . $adm['ADM_ID'] . "</td>";
        //     echo "<td>" . $adm['ADM_NOME'] . "</td>";
        //     echo "<td>" . $adm['ADM_EMAIL'] . "</td>";
        //     echo "<td>" . $adm['ADM_SENHA'] . "</td>";
        //     echo "<td>" . $adm['ADM_ATIVO'] . "</td>";
        //     echo "<td><a href='./excluir_administrador.php?id=" . $adm['ADM_ID'] . "'>Excluir</a></td>";
        //     echo "<td><a href='./editar_admin.php?adm_id=" . $adm['ADM_ID'] . "'>Editar</a></td>";
        //     echo "</tr>";
        // }
        ?>
    </table>
    <p><a href="./cadastrar_administrador.php">Cadastrar Administrador</a></p>
</body>

</html>