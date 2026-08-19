<?php

session_start();

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION["ID_CLI"]) || $_SESSION["ID_CLI"] != 1) {
    header("Location: ../loginusuario.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastrar Produto | Rei do Açaí</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 min-h-screen">


    <!-- ================================================= -->
    <!-- MENU LATERAL -->
    <!-- ================================================= -->

    <aside class="fixed left-0 top-0 h-screen w-64 bg-purple-800 text-white">

        <!-- Logo / identificação -->

        <div class="px-6 py-7 border-b border-purple-700">

            <h1 class="text-2xl font-bold">
                Rei do Açaí
            </h1>

            <p class="text-purple-200 text-sm mt-1">
                Painel administrativo
            </p>

        </div>


        <!-- Navegação -->

        <nav class="px-4 py-5">

            <!-- Início -->

            <a
                href="index.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg
                       hover:bg-purple-700 transition duration-200 mb-2"
            >

                <span class="text-lg">
                    🏠
                </span>

                <span>
                    Início
                </span>

            </a>


            <!-- Produtos -->

            <a
                href="produtos.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg
                       bg-purple-700 mb-2"
            >

                <span class="text-lg">
                    📦
                </span>

                <span>
                    Produtos
                </span>

            </a>


            <!-- Adicionais -->

            <a
                href="adicionais.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg
                       hover:bg-purple-700 transition duration-200 mb-2"
            >

                <span class="text-lg">
                    🥣
                </span>

                <span>
                    Adicionais
                </span>

            </a>


            <!-- Clientes -->

            <a
                href="clientes.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg
                       hover:bg-purple-700 transition duration-200 mb-2"
            >

                <span class="text-lg">
                    👥
                </span>

                <span>
                    Clientes
                </span>

            </a>


            <!-- Relatórios -->

            <a
                href="relatorio.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg
                       hover:bg-purple-700 transition duration-200 mb-2"
            >

                <span class="text-lg">
                    📊
                </span>

                <span>
                    Relatórios
                </span>

            </a>

        </nav>


        <!-- Voltar para o site -->

        <div
            class="absolute bottom-0 left-0 w-full
                   p-4 border-t border-purple-700"
        >

            <a
                href="../index.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg
                       hover:bg-purple-700 transition duration-200"
            >

                <span class="text-lg">
                    ←
                </span>

                <span>
                    Voltar para o site
                </span>

            </a>

        </div>

    </aside>



    <!-- ================================================= -->
    <!-- CONTEÚDO PRINCIPAL -->
    <!-- ================================================= -->

    <main class="ml-64 p-8">

        <div class="max-w-4xl mx-auto">


            <!-- CABEÇALHO -->

            <div class="mb-8">

                <p class="text-sm text-purple-700 font-medium mb-1">
                    Produtos
                </p>

                <h2 class="text-3xl font-bold text-gray-800">
                    Cadastrar produto
                </h2>

                <p class="text-gray-500 mt-1">
                    Adicione um novo produto ao catálogo do Rei do Açaí.
                </p>

            </div>



            <!-- ================================================= -->
            <!-- FORMULÁRIO -->
            <!-- ================================================= -->

            <form
                action="../processa/cadastro_produto.php"
                method="POST"
                enctype="multipart/form-data"
                class="bg-white rounded-2xl shadow-sm
                       border border-gray-100 p-8"
            >

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                    <!-- NOME DO PRODUTO -->

                    <div class="md:col-span-2">

                        <label
                            for="nome_prod"
                            class="block text-sm font-medium
                                   text-gray-700 mb-2"
                        >
                            Nome do produto
                        </label>

                        <input
                            type="text"
                            id="nome_prod"
                            name="nome_prod"
                            maxlength="30"
                            required
                            placeholder="Ex.: Açaí 500ml"
                            class="w-full px-4 py-3
                                   border border-gray-300
                                   rounded-lg
                                   bg-white
                                   text-gray-800
                                   placeholder-gray-400
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-purple-500
                                   focus:border-purple-500
                                   transition"
                        >

                    </div>



                    <!-- TIPO -->

                    <div>

                        <label
                            for="tipo_prod"
                            class="block text-sm font-medium
                                   text-gray-700 mb-2"
                        >
                            Tipo do produto
                        </label>

                        <select
                            id="tipo_prod"
                            name="tipo_prod"
                            required
                            class="w-full px-4 py-3
                                   border border-gray-300
                                   rounded-lg
                                   bg-white
                                   text-gray-800
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-purple-500
                                   focus:border-purple-500"
                        >

                            <option value="">
                                Selecione o tipo
                            </option>

                            <option value="Copo">
                                Copo
                            </option>

                            <option value="Pote">
                                Pote
                            </option>

                        </select>

                    </div>



                    <!-- VALOR -->

                    <div>

                        <label
                            for="valor_prod"
                            class="block text-sm font-medium
                                   text-gray-700 mb-2"
                        >
                            Valor do produto
                        </label>

                        <div class="relative">

                            <span
                                class="absolute left-4 top-1/2
                                       -translate-y-1/2
                                       text-gray-500
                                       font-medium"
                            >
                                R$
                            </span>

                            <input
                                type="number"
                                id="valor_prod"
                                name="valor_prod"
                                min="0"
                                step="0.01"
                                required
                                placeholder="0,00"
                                class="w-full pl-12 pr-4 py-3
                                       border border-gray-300
                                       rounded-lg
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-purple-500
                                       focus:border-purple-500"
                            >

                        </div>

                    </div>



                    <!-- ESTOQUE -->

                    <div>

                        <label
                            for="estoque"
                            class="block text-sm font-medium
                                   text-gray-700 mb-2"
                        >
                            Quantidade em estoque
                        </label>

                        <input
                            type="number"
                            id="estoque"
                            name="estoque"
                            min="0"
                            required
                            placeholder="Ex.: 30"
                            class="w-full px-4 py-3
                                   border border-gray-300
                                   rounded-lg
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-purple-500
                                   focus:border-purple-500"
                        >

                    </div>



                    <!-- IMAGEM -->

                    <div>

                        <label
                            for="imagem"
                            class="block text-sm font-medium
                                   text-gray-700 mb-2"
                        >
                            Imagem do produto
                        </label>

                        <input
                            type="file"
                            id="imagem"
                            name="imagem"
                            accept=".jpg,.jpeg,.png,.webp"
                            class="w-full px-4 py-2.5
                                   border border-gray-300
                                   rounded-lg
                                   bg-white
                                   text-sm
                                   text-gray-600
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-purple-500"
                        >

                        <p class="text-xs text-gray-400 mt-2">
                            JPG, JPEG, PNG ou WEBP.
                        </p>

                    </div>

                </div>



                <!-- ================================================= -->
                <!-- BOTÕES -->
                <!-- ================================================= -->

                <div
                    class="border-t border-gray-100
                           mt-8 pt-6"
                >

                    <div
                        class="flex flex-col-reverse
                               sm:flex-row
                               items-center
                               justify-end
                               gap-3"
                    >

                        <!-- CANCELAR -->

                        <a
                            href="produtos.php"
                            class="w-full sm:w-auto
                                   text-center
                                   px-5 py-3
                                   rounded-lg
                                   border border-gray-300
                                   text-gray-700
                                   font-medium
                                   hover:bg-gray-50
                                   transition duration-200"
                        >
                            Cancelar
                        </a>


                        <!-- CADASTRAR -->

                        <button
                            type="submit"
                            class="w-full sm:w-auto
                                   px-6 py-3
                                   rounded-lg
                                   bg-purple-700
                                   hover:bg-purple-800
                                   text-white
                                   font-medium
                                   shadow-sm
                                   hover:shadow
                                   transition duration-200"
                        >
                            Cadastrar produto
                        </button>

                    </div>

                </div>

            </form>



            <!-- ================================================= -->
            <!-- DICA -->
            <!-- ================================================= -->

            <div
                class="mt-6
                       bg-purple-50
                       border border-purple-100
                       rounded-xl
                       p-5"
            >

                <div class="flex items-start gap-3">

                    <span class="text-xl">
                        💡
                    </span>

                    <div>

                        <h4
                            class="font-semibold
                                   text-purple-800"
                        >
                            Dica
                        </h4>

                        <p
                            class="text-sm
                                   text-purple-700
                                   mt-1"
                        >
                            Utilize uma imagem clara do produto para
                            facilitar sua identificação no catálogo.
                        </p>

                    </div>

                </div>

            </div>


        </div>

    </main>


</body>

</html>