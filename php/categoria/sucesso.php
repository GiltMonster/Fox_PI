<?php
    if(isset($_GET['status']) && $_GET['status'] == 'sucesso') {
        echo '<p class="msg-sucesso">Categoria cadastrada com sucesso!</p>';
        echo '<a href="../../pages/produto/CadastrarProdutos.php">Cadastrar outra categoria</a>';
    }

?>