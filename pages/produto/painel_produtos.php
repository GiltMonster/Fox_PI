<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/index.css">
    <link rel="stylesheet" href="../../style/produto/painel_produto.css">
    <title>Painel de Produtos</title>
</head>

<body>
    <header class="navbar">
        <div>
            <img src="../../images/fox.svg" alt="fox logo" />
            <nav>
                <ul>
                    <li><a href="../../index.php">Home</a></li>
                    <li><a href="../../pages/admin/painel_admin.php">Administradores</a></li>
                    <li><a href="./painel_produtos.php">Produtos</a></li>
                </ul>
            </nav>
        </div>

        <button class="btn-sair">Sair</button>
    </header>
    <main>
        <section class="container">
            <div class="pesquisa-header">
                <h2>Estoque</h2>

                <form method="POST" class="pesquisa-form">
                    <input type="text" placeholder="Buscar produto" name="produto_nome" />
                    <button type="submit">
                        <img src="../../images/icons/search.svg" alt="search">
                    </button>


                </form>
                <a class="btn-produto" href="../../pages/admin/cadastrar_administrador.php">
                    <!-- <svg class="feather feather-user-plus" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="8.5" cy="7" r="4" />
                        <line x1="20" x2="20" y1="8" y2="14" />
                        <line x1="23" x2="17" y1="11" y2="11" />
                    </svg> -->
                    <label>
                        Cadastrar produto
                    </label>
                </a>

            </div>
            <!-- <div class="container-buttons">
                <a class="btn-produto" href="./CadastrarProdutos.php">
                    <svg class="feather feather-user-plus" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="8.5" cy="7" r="4" />
                        <line x1="20" x2="20" y1="8" y2="14" />
                        <line x1="23" x2="17" y1="11" y2="11" />
                    </svg>
                    <label>
                        Cadastrar produto
                    </label>
                </a>
                <a class="btn-produto" href="../../pages/produto/listar_produto.php">
                    <svg fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" d="M20 4H4C3.44771 4 3 4.44772 3 5V19C3 19.5523 3.44772 20 4 20H20C20.5523 20 21 19.5523 21 19V5C21 4.44771 20.5523 4 20 4ZM4 2C2.34315 2 1 3.34315 1 5V19C1 20.6569 2.34315 22 4 22H20C21.6569 22 23 20.6569 23 19V5C23 3.34315 21.6569 2 20 2H4ZM6 7H8V9H6V7ZM11 7C10.4477 7 10 7.44772 10 8C10 8.55228 10.4477 9 11 9H17C17.5523 9 18 8.55228 18 8C18 7.44772 17.5523 7 17 7H11ZM8 11H6V13H8V11ZM10 12C10 11.4477 10.4477 11 11 11H17C17.5523 11 18 11.4477 18 12C18 12.5523 17.5523 13 17 13H11C10.4477 13 10 12.5523 10 12ZM8 15H6V17H8V15ZM10 16C10 15.4477 10.4477 15 11 15H17C17.5523 15 18 15.4477 18 16C18 16.5523 17.5523 17 17 17H11C10.4477 17 10 16.5523 10 16Z" fill="currentColor" fill-rule="evenodd" />
                    </svg>
                    <label>
                        Listar produtos
                    </label>
                </a>
            </div> -->


        </section>
    </main>
</body>

</html>