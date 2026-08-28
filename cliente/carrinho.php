<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Carrinho | Rei do Açaí</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-gray-100 text-gray-800">


<!-- =========================================================
     CABEÇALHO
========================================================= -->

<header class="bg-purple-800 text-white">

    <div class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">

        <a
            href="cardapio.php"
            class="text-3xl font-bold">

            Rei do Açaí

        </a>


        <nav class="flex items-center gap-6">

            <a
                href="cardapio.php"
                class="hover:text-yellow-300 transition">

                Cardápio

            </a>


            <a
                href="carrinho.php"
                class="text-yellow-300 font-semibold">

                🛒 Carrinho

            </a>


            <a
                href="../loginusuario.php"
                class="bg-yellow-400 text-black px-4 py-2 rounded-lg font-bold hover:bg-yellow-300 transition">

                Login

            </a>

        </nav>

    </div>

</header>


<!-- =========================================================
     TÍTULO
========================================================= -->

<section class="bg-purple-700 text-white py-10">

    <div class="max-w-7xl mx-auto px-6">

        <p class="text-purple-200 mb-2">

            Rei do Açaí

        </p>


        <h1 class="text-4xl font-bold">

            Meu Carrinho

        </h1>


        <p class="mt-2 text-purple-100">

            Confira seus produtos antes de continuar.

        </p>

    </div>

</section>


<!-- =========================================================
     CONTEÚDO
========================================================= -->

<main class="max-w-7xl mx-auto px-6 py-10">


    <!-- CARRINHO VAZIO -->

    <div
        id="carrinhoVazio"
        class="hidden bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">


        <div class="text-6xl mb-5">

            🛒

        </div>


        <h2 class="text-2xl font-bold">

            Seu carrinho está vazio

        </h2>


        <p class="text-gray-500 mt-2">

            Adicione um produto pelo cardápio para continuar.

        </p>


        <a
            href="cardapio.php"
            class="inline-block mt-6 bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-800 transition">

            Ver cardápio

        </a>

    </div>


    <!-- =====================================================
         CARRINHO COM PRODUTOS
    ====================================================== -->

    <div
        id="carrinhoConteudo"
        class="hidden grid grid-cols-1 lg:grid-cols-3 gap-8">


        <!-- =================================================
             LISTA DE PRODUTOS
        ================================================== -->

        <section class="lg:col-span-2 space-y-4">


            <div class="flex justify-between items-center mb-4">

                <h2 class="text-2xl font-bold">

                    Produtos

                </h2>


                <button
                    id="limparCarrinho"
                    type="button"
                    class="text-red-600 text-sm font-semibold hover:text-red-800">

                    Limpar carrinho

                </button>

            </div>


            <!-- Os produtos serão inseridos pelo JavaScript -->

            <div id="listaCarrinho"></div>


        </section>


        <!-- =================================================
             RESUMO
        ================================================== -->

        <aside>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">


                <h2 class="text-xl font-bold mb-6">

                    Resumo do pedido

                </h2>


                <div class="flex justify-between text-gray-600 mb-3">

                    <span>

                        Produtos

                    </span>


                    <span id="subtotalCarrinho">

                        R$ 0,00

                    </span>

                </div>


                <div class="flex justify-between text-gray-600 mb-4">

                    <span>

                        Adicionais

                    </span>


                    <span id="valorAdicionaisCarrinho">

                        R$ 0,00

                    </span>

                </div>


                <div
                    class="border-t border-gray-200 pt-4 flex justify-between items-center">


                    <span class="text-lg font-bold">

                        Total

                    </span>


                    <span
                        id="totalCarrinho"
                        class="text-2xl font-bold text-purple-700">

                        R$ 0,00

                    </span>

                </div>


                <button
                    id="finalizarPedido"
                    type="button"
                    class="mt-6 w-full bg-purple-700 text-white py-3 rounded-lg font-bold hover:bg-purple-800 transition">

                    Finalizar pedido

                </button>


                <a
                    href="cardapio.php"
                    class="block text-center mt-4 text-purple-700 font-semibold hover:text-purple-900">

                    Continuar comprando

                </a>

            </div>

        </aside>

    </div>

</main>


<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script src="../js/carrinho.js"></script>


</body>

</html>