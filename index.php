```php
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rei do Açaí</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 text-gray-800">

    <!-- CABEÇALHO -->

    <header class="bg-purple-800 text-white">

        <div class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">

            <h1 class="text-3xl font-bold">
                Rei do Açaí
            </h1>

            <nav class="flex items-center gap-6">

                <a href="#" class="hover:text-yellow-300 transition">
                    Minha conta
                </a>

                <a href="#" class="hover:text-yellow-300 transition">
                    Pedidos
                </a>

                <a href="cliente/carrinho.php"
                   class="hover:text-yellow-300 transition">
                    Carrinho
                </a>

                <a href="loginusuario.php"
                   class="bg-yellow-400 text-black px-4 py-2 rounded-lg font-bold hover:bg-yellow-300 transition">
                    Login
                </a>

            </nav>

        </div>

    </header>


    <!-- BANNER -->

    <section class="min-h-[500px] flex flex-col justify-center items-center text-center bg-purple-700 text-white px-6">

        <h2 class="text-5xl font-bold mb-5">
            Monte seu Açaí do seu jeito
        </h2>

        <p class="text-xl mb-8">
            Escolha o tamanho, personalize com seus adicionais e faça seu pedido.
        </p>

        <button
            id="btnCardapio"
            class="bg-yellow-400 text-black px-8 py-4 rounded-lg font-bold text-lg hover:bg-yellow-300 transition">

            Ver Cardápio

        </button>

    </section>


    <!-- CATEGORIAS -->

    <section class="max-w-7xl mx-auto px-6 py-12">

        <h2 class="text-3xl font-bold mb-8">
            Categorias
        </h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">

            <button class="categoria-btn bg-white shadow rounded-xl px-6 py-5 hover:shadow-lg transition"
                    data-categoria="Copo">

                <span class="text-3xl block mb-2">
                    🥤
                </span>

                <span class="font-semibold">
                    Copos
                </span>

            </button>


            <button class="categoria-btn bg-white shadow rounded-xl px-6 py-5 hover:shadow-lg transition"
                    data-categoria="Pote">

                <span class="text-3xl block mb-2">
                    🍨
                </span>

                <span class="font-semibold">
                    Potes
                </span>

            </button>


            <button class="categoria-btn bg-white shadow rounded-xl px-6 py-5 hover:shadow-lg transition"
                    data-categoria="Premium">

                <span class="text-3xl block mb-2">
                    👑
                </span>

                <span class="font-semibold">
                    Premium
                </span>

            </button>


            <button class="categoria-btn bg-white shadow rounded-xl px-6 py-5 hover:shadow-lg transition"
                    data-categoria="Todos">

                <span class="text-3xl block mb-2">
                    🍓
                </span>

                <span class="font-semibold">
                    Ver todos
                </span>

            </button>

        </div>

    </section>


    <!-- MAIS VENDIDOS -->

    <section class="max-w-7xl mx-auto px-6 py-12">

        <div class="flex justify-between items-center mb-8">

            <div>

                <h2 class="text-3xl font-bold">
                    Mais vendidos
                </h2>

                <p class="text-gray-500 mt-1">
                    Confira alguns dos nossos produtos.
                </p>

            </div>

            <a href="cliente/cardapio.php"
               class="text-purple-700 font-semibold hover:underline">

                Ver cardápio completo →

            </a>

        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">


            <!-- PRODUTO 1 -->

            <div class="bg-white rounded-xl shadow p-5">

                <div class="bg-gray-200 h-48 rounded-lg flex items-center justify-center">

                    <span class="text-gray-400">
                        Produto
                    </span>

                </div>

                <h3 class="text-xl font-bold mt-5">
                    Açaí 400ml
                </h3>

                <p class="text-purple-700 font-bold text-lg mt-2">
                    R$ 25,00
                </p>

                <a href="cliente/cardapio.php"
                   class="block text-center mt-4 w-full bg-purple-700 text-white py-3 rounded-lg hover:bg-purple-800 transition">

                    Comprar

                </a>

            </div>


            <!-- PRODUTO 2 -->

            <div class="bg-white rounded-xl shadow p-5">

                <div class="bg-gray-200 h-48 rounded-lg flex items-center justify-center">

                    <span class="text-gray-400">
                        Produto
                    </span>

                </div>

                <h3 class="text-xl font-bold mt-5">
                    Açaí 500ml
                </h3>

                <p class="text-purple-700 font-bold text-lg mt-2">
                    R$ 27,00
                </p>

                <a href="cliente/cardapio.php"
                   class="block text-center mt-4 w-full bg-purple-700 text-white py-3 rounded-lg hover:bg-purple-800 transition">

                    Comprar

                </a>

            </div>


            <!-- PRODUTO 3 -->

            <div class="bg-white rounded-xl shadow p-5">

                <div class="bg-gray-200 h-48 rounded-lg flex items-center justify-center">

                    <span class="text-gray-400">
                        Produto
                    </span>

                </div>

                <h3 class="text-xl font-bold mt-5">
                    Açaí 700ml
                </h3>

                <p class="text-purple-700 font-bold text-lg mt-2">
                    R$ 35,00
                </p>

                <a href="cliente/cardapio.php"
                   class="block text-center mt-4 w-full bg-purple-700 text-white py-3 rounded-lg hover:bg-purple-800 transition">

                    Comprar

                </a>

            </div>


            <!-- PRODUTO 4 -->

            <div class="bg-white rounded-xl shadow p-5">

                <div class="bg-gray-200 h-48 rounded-lg flex items-center justify-center">

                    <span class="text-gray-400">
                        Produto
                    </span>

                </div>

                <h3 class="text-xl font-bold mt-5">
                    Açaí 1 Litro
                </h3>

                <p class="text-purple-700 font-bold text-lg mt-2">
                    R$ 50,00
                </p>

                <a href="cliente/cardapio.php"
                   class="block text-center mt-4 w-full bg-purple-700 text-white py-3 rounded-lg hover:bg-purple-800 transition">

                    Comprar

                </a>

            </div>

        </div>

    </section>


    <!-- COMO FUNCIONA -->

    <section class="bg-white py-14">

        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-3xl font-bold text-center mb-10">
                Como funciona
            </h2>


            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">

                <div>

                    <div class="text-4xl mb-4">
                        🥤
                    </div>

                    <h3 class="text-2xl font-bold mb-2">
                        1. Escolha
                    </h3>

                    <p class="text-gray-600">
                        Escolha o tamanho do seu açaí.
                    </p>

                </div>


                <div>

                    <div class="text-4xl mb-4">
                        🍓
                    </div>

                    <h3 class="text-2xl font-bold mb-2">
                        2. Personalize
                    </h3>

                    <p class="text-gray-600">
                        Escolha os adicionais que deseja.
                    </p>

                </div>


                <div>

                    <div class="text-4xl mb-4">
                        🚚
                    </div>

                    <h3 class="text-2xl font-bold mb-2">
                        3. Receba
                    </h3>

                    <p class="text-gray-600">
                        Acompanhe seu pedido até a entrega.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- RODAPÉ -->

    <footer class="bg-purple-800 text-white p-8 mt-10">

        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between gap-5">

            <p>
                © 2026 Rei do Açaí
            </p>

            <div class="flex gap-5">

                <a href="#" class="hover:text-yellow-300">
                    Instagram
                </a>

                <a href="#" class="hover:text-yellow-300">
                    WhatsApp
                </a>

                <a href="#" class="hover:text-yellow-300">
                    Contato
                </a>

            </div>

        </div>

    </footer>


    <!-- JAVASCRIPT -->

    <script src="js/index.js"></script>

</body>

</html>
```
