<?php

session_start();

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION["ID_CLI"]) || $_SESSION["ID_CLI"] != 1) {
    header("Location: ../loginusuario.php");
    exit;
}

$usuario = $_SESSION["USUARIO"] ?? "Administrador";

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Painel Administrativo | Rei do Açaí</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Menu lateral -->

    <aside class="fixed left-0 top-0 h-screen w-64 bg-purple-800 text-white">

        <div class="px-6 py-7">

            <h1 class="text-2xl font-bold">
                Rei do Açaí
            </h1>

            <p class="text-purple-200 text-sm mt-1">
                Painel administrativo
            </p>

        </div>


        <nav class="px-4">

            <a
                href="index.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg bg-purple-700 mb-2"
            >
                <span>🏠</span>
                <span>Início</span>
            </a>


            <a
                href="produtos.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition mb-2"
            >
                <span>📦</span>
                <span>Produtos</span>
            </a>


            <a
                href="adicionais.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition mb-2"
            >
                <span>🥣</span>
                <span>Adicionais</span>
            </a>

            <a href="pedidos.php"
    class="flex items-center gap-3 px-4 py-3 rounded-lg bg-purple-700 mb-2">
    <span class="text-lg">🧾</span>
    <span>Pedidos</span>
</a>

            <a
                href="cliente.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition mb-2"
            >
                <span>👥</span>
                <span>Clientes</span>
            </a>


            <a
                href="relatorio.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition mb-2"
            >
                <span>📊</span>
                <span>Relatórios</span>
            </a>

        </nav>


        <!-- Parte inferior do menu -->

        <div class="absolute bottom-0 left-0 w-full p-4 border-t border-purple-700">

            <a
                href="../index.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition"
            >
                <span>←</span>
                <span>Voltar para o site</span>
            </a>

        </div>

    </aside>


    <!-- Conteúdo principal -->

    <main class="ml-64 p-8">

        <!-- Cabeçalho -->

        <div class="flex items-center justify-between mb-8">

            <div>

                <h2 class="text-3xl font-bold text-gray-800">
                    Olá, <?php echo htmlspecialchars($usuario); ?>!
                </h2>

                <p class="text-gray-500 mt-1">
                    Seja bem-vindo ao painel administrativo.
                </p>

            </div>


            <div class="bg-white px-5 py-3 rounded-xl shadow-sm">

                <p class="text-sm text-gray-500">
                    Acesso
                </p>

                <p class="font-semibold text-gray-800">
                    Administrador
                </p>

            </div>

        </div>


        <!-- Resumo -->

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">


            <!-- Produtos -->

            <div class="bg-white rounded-xl shadow-sm p-6">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-gray-500 text-sm">
                            Produtos cadastrados
                        </p>

                        <p class="text-3xl font-bold text-gray-800 mt-2">
                            0
                        </p>

                    </div>

                    <div class="bg-purple-100 text-purple-700 rounded-lg p-3 text-xl">
                        📦
                    </div>

                </div>

            </div>


            <!-- Adicionais -->

            <div class="bg-white rounded-xl shadow-sm p-6">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-gray-500 text-sm">
                            Adicionais cadastrados
                        </p>

                        <p class="text-3xl font-bold text-gray-800 mt-2">
                            0
                        </p>

                    </div>

                    <div class="bg-purple-100 text-purple-700 rounded-lg p-3 text-xl">
                        🥣
                    </div>

                </div>

            </div>


            <!-- Clientes -->

            <div class="bg-white rounded-xl shadow-sm p-6">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-gray-500 text-sm">
                            Clientes cadastrados
                        </p>

                        <p class="text-3xl font-bold text-gray-800 mt-2">
                            0
                        </p>

                    </div>

                    <div class="bg-purple-100 text-purple-700 rounded-lg p-3 text-xl">
                        👥
                    </div>

                </div>

            </div>

        </div>


        <!-- Área de gerenciamento -->

        <div class="bg-white rounded-xl shadow-sm p-6">

            <div class="mb-6">

                <h3 class="text-xl font-bold text-gray-800">
                    Gerenciamento
                </h3>

                <p class="text-gray-500 mt-1">
                    Acesse as principais funções do sistema.
                </p>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">


                <!-- Produtos -->

                <a
                    href="produtos.php"
                    class="border border-gray-200 rounded-xl p-5 hover:border-purple-500 hover:shadow-sm transition"
                >

                    <div class="text-2xl mb-3">
                        📦
                    </div>

                    <h4 class="font-semibold text-gray-800">
                        Produtos
                    </h4>

                    <p class="text-sm text-gray-500 mt-1">
                        Cadastre e gerencie os produtos disponíveis.
                    </p>

                </a>


                <!-- Adicionais -->

                <a
                    href="adicionais.php"
                    class="border border-gray-200 rounded-xl p-5 hover:border-purple-500 hover:shadow-sm transition"
                >

                    <div class="text-2xl mb-3">
                        🥣
                    </div>

                    <h4 class="font-semibold text-gray-800">
                        Adicionais
                    </h4>

                    <p class="text-sm text-gray-500 mt-1">
                        Gerencie os adicionais oferecidos aos clientes.
                    </p>

                </a>


                <!-- Clientes -->

                <a
                    href="clientes.php"
                    class="border border-gray-200 rounded-xl p-5 hover:border-purple-500 hover:shadow-sm transition"
                >

                    <div class="text-2xl mb-3">
                        👥
                    </div>

                    <h4 class="font-semibold text-gray-800">
                        Clientes
                    </h4>

                    <p class="text-sm text-gray-500 mt-1">
                        Consulte os clientes cadastrados no sistema.
                    </p>

                </a>

            </div>

        </div>


        <!-- Aviso -->

        <div class="mt-6 bg-purple-50 border border-purple-100 rounded-xl p-5">

            <h4 class="font-semibold text-purple-800">
                Painel administrativo
            </h4>

            <p class="text-sm text-purple-700 mt-1">
                Utilize o menu lateral para acessar as funcionalidades
                de gerenciamento do Rei do Açaí.
            </p>

        </div>

    </main>

</body>

</html>