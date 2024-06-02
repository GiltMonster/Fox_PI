<?php

session_start(); //inicia a sessão

// var_dump($_SESSION['admin_logado']);
if (!isset($_SESSION['admin_logado'])) {
    header('Location: ./pages/login/login.php'); //redireciona para a página login.php        
    exit(); //finaliza a execução do script
} else {
    $admin = $_SESSION['admin_logado'];
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ./pages/login/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/index.css">
    <link rel="icon" href="./favicon.ico" />
    <title>Painel admin</title>
    <script src="./js/date.js"></script>
</head>

<body>

    <header class="navbar-index">
        <img src="./images/fox.svg" alt="fox logo" />
        <a class="btn-sair" href="./index.php?logout">Sair</a>
    </header>
    <main>
        <section class="container">
            <div class="sub-header">
                <h1>Seja bem-vindo, <label class="name-admin"><?= $admin["ADM_NOME"] ?></label> o que deseja ? </h1>
                <p id="date"></p>
            </div>
            <div class="container-buttons">
                <a class="btn-produto" href="./pages/admin/painel_admin.php">
                    <svg class="feather feather-user-plus" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="8.5" cy="7" r="4" />
                        <line x1="20" x2="20" y1="8" y2="14" />
                        <line x1="23" x2="17" y1="11" y2="11" />
                    </svg>
                    <label>
                        Gerenciar administradores
                    </label>
                </a>
                <a class="btn-produto" href="./pages/produto/painel_produtos.php">
                    <svg class="feather feather-user-plus" fill="currentColor" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg">

                        <path d="M229.9,70.8h0a.1.1,0,0,1-.1-.1,16.2,16.2,0,0,0-6-5.9l-88-49.5a16,16,0,0,0-15.6,0l-88,49.5a16.2,16.2,0,0,0-6,5.9.1.1,0,0,1-.1.1v.2A15,15,0,0,0,24,78.7v98.6a16.1,16.1,0,0,0,8.2,14l88,49.5a16.5,16.5,0,0,0,7.2,2h1.4a15.7,15.7,0,0,0,7-2l88-49.5a16.1,16.1,0,0,0,8.2-14V78.7A15.6,15.6,0,0,0,229.9,70.8ZM128,29.2,207.7,74,177.1,91.4,96.4,46.9Zm.9,89.6L48.4,74,80,56.2l80.8,44.5Zm7.2,103.5.8-89.6L169,114.4v38.1a8,8,0,0,0,16,0V105.3l31-17.6v89.6Z" />
                    </svg>
                    <label>
                        Gerenciar produtos
                    </label>
                </a>
                <a class="btn-produto" href="./pages/categoria/painel_categoria.php">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 50 50" id="Module-Three--Streamline-Nova" height="50" width="50">
                        <desc>Module Three Streamline Icon: https://streamlinehq.com/</desc>
                        <path fill="#000000" fill-rule="evenodd" d="M15.645354166666667 0c-1.1506041666666667 0 -2.0833333333333335 0.9327395833333334 -2.0833333333333335 2.0833333333333335v18.75c0 1.150625 0.9327291666666667 2.0833333333333335 2.0833333333333335 2.0833333333333335h18.750062500000002c1.1504166666666669 0 2.0833333333333335 -0.9327083333333334 2.0833333333333335 -2.0833333333333335V2.0833333333333335c0 -1.15059375 -0.9329166666666667 -2.0833333333333335 -2.0833333333333335 -2.0833333333333335H15.645354166666667Zm2.0833333333333335 18.75V4.166666666666667h14.583395833333334v14.583333333333334H17.7286875ZM0 29.166666666666668c0 -1.150625 0.9327395833333334 -2.0833333333333335 2.0833333333333335 -2.0833333333333335h18.75c1.150625 0 2.0833333333333335 0.9327083333333334 2.0833333333333335 2.0833333333333335v18.75c0 1.150625 -0.9327083333333334 2.0833333333333335 -2.0833333333333335 2.0833333333333335H2.0833333333333335c-1.15059375 0 -2.0833333333333335 -0.9327083333333334 -2.0833333333333335 -2.0833333333333335v-18.75Zm4.166666666666667 2.0833333333333335v14.583333333333334h14.583333333333334v-14.583333333333334H4.166666666666667Zm22.916666666666668 -2.0833333333333335c0 -1.150625 0.9327083333333334 -2.0833333333333335 2.0833333333333335 -2.0833333333333335h18.75c1.150625 0 2.0833333333333335 0.9327083333333334 2.0833333333333335 2.0833333333333335v18.75c0 1.150625 -0.9327083333333334 2.0833333333333335 -2.0833333333333335 2.0833333333333335h-18.75c-1.150625 0 -2.0833333333333335 -0.9327083333333334 -2.0833333333333335 -2.0833333333333335v-18.75Zm4.166666666666667 2.0833333333333335v14.583333333333334h14.583333333333334v-14.583333333333334h-14.583333333333334Z" clip-rule="evenodd" stroke-width="1"></path>
                    </svg>
                    <label>
                        Gerenciar as categorias dos produtos.
                    </label>
                </a>
                <a class="btn-produto" href="./pages/dados/painel_dados.php">
                    <svg class="feather feather-pie-chart" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.21 15.89A10 10 0 1 1 8 2.83" />
                        <path d="M22 12A10 10 0 0 0 12 2v10z" />
                    </svg>
                    <label>
                        Dashboard
                    </label>
                </a>
            </div>
        </section>
</body>


</html>