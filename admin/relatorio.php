<?php

session_start();

if (!isset($_SESSION["ID_CLI"]) || $_SESSION["ID_CLI"] != 1) {
    header("Location: ../loginusuario.php");
    exit;
}

require_once "../config/conexao.php";


// ======================================================
// INDICADORES PRINCIPAIS
// ======================================================

// Total de clientes
$resultado = $conexao->query("
    SELECT COUNT(*) AS total
    FROM CLIENTE
    WHERE ID_CLI <> 1
");

$total_clientes = $resultado
    ? (int) $resultado->fetch_assoc()["total"]
    : 0;


// Total de produtos
$resultado = $conexao->query("
    SELECT COUNT(*) AS total
    FROM PRODUTO
");

$total_produtos = $resultado
    ? (int) $resultado->fetch_assoc()["total"]
    : 0;


// Total de adicionais
$resultado = $conexao->query("
    SELECT COUNT(*) AS total
    FROM ADICIONAL
");

$total_adicionais = $resultado
    ? (int) $resultado->fetch_assoc()["total"]
    : 0;


// Total de pedidos
$resultado = $conexao->query("
    SELECT COUNT(*) AS total
    FROM PEDIDO
");

$total_pedidos = $resultado
    ? (int) $resultado->fetch_assoc()["total"]
    : 0;


// Valor total dos pedidos
$resultado = $conexao->query("
    SELECT COALESCE(SUM(VALOR_TOTAL), 0) AS total
    FROM PEDIDO
    WHERE STATUS_PED <> 'Cancelado'
");

$total_vendas = $resultado
    ? (float) $resultado->fetch_assoc()["total"]
    : 0;


// ======================================================
// PEDIDOS POR STATUS
// ======================================================

$status_pedidos = [
    "Recebido" => 0,
    "Em preparo" => 0,
    "Saiu para entrega" => 0,
    "Entregue" => 0,
    "Cancelado" => 0
];

$resultado = $conexao->query("
    SELECT STATUS_PED, COUNT(*) AS total
    FROM PEDIDO
    GROUP BY STATUS_PED
");

if ($resultado) {

    while ($linha = $resultado->fetch_assoc()) {

        $status = $linha["STATUS_PED"];

        if (isset($status_pedidos[$status])) {
            $status_pedidos[$status] = (int) $linha["total"];
        }
    }
}


// ======================================================
// PRODUTOS MAIS VENDIDOS
// ======================================================

$produtos_vendidos = [];

$sql_produtos = "
    SELECT
        pr.NOME_PROD,
        COALESCE(SUM(i.QUANTIDADE), 0) AS quantidade

    FROM ITEM_PEDIDO i

    INNER JOIN PRODUTO pr
        ON i.COD_PROD = pr.ID_PROD

    INNER JOIN PEDIDO p
        ON i.COD_PED = p.ID_PED

    WHERE p.STATUS_PED <> 'Cancelado'

    GROUP BY pr.ID_PROD, pr.NOME_PROD

    ORDER BY quantidade DESC

    LIMIT 5
";

$resultado = $conexao->query($sql_produtos);

if ($resultado) {

    while ($linha = $resultado->fetch_assoc()) {

        $produtos_vendidos[] = [
            "nome" => $linha["NOME_PROD"],
            "quantidade" => (int) $linha["quantidade"]
        ];
    }
}


// ======================================================
// ÚLTIMOS PEDIDOS
// ======================================================

$ultimos_pedidos = [];

$sql_ultimos = "
    SELECT
        p.ID_PED,
        p.STATUS_PED,
        p.VALOR_TOTAL,
        p.DATA_PED,
        c.NOME_CLI

    FROM PEDIDO p

    INNER JOIN CLIENTE c
        ON p.COD_CLI = c.ID_CLI

    ORDER BY p.DATA_PED DESC

    LIMIT 5
";

$resultado = $conexao->query($sql_ultimos);

if ($resultado) {

    while ($linha = $resultado->fetch_assoc()) {

        $ultimos_pedidos[] = $linha;
    }
}


// ======================================================
// DADOS PARA O JAVASCRIPT
// ======================================================

$dados_status = [
    "Recebido" => $status_pedidos["Recebido"],
    "Em preparo" => $status_pedidos["Em preparo"],
    "Saiu para entrega" => $status_pedidos["Saiu para entrega"],
    "Entregue" => $status_pedidos["Entregue"],
    "Cancelado" => $status_pedidos["Cancelado"]
];

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Relatórios | Rei do Açaí</title>


    <!-- Tailwind -->

    <script src="https://cdn.tailwindcss.com"></script>


    <!-- Chart.js -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>


<body class="bg-gray-100 min-h-screen">


    <!-- ==================================================
         MENU LATERAL
    =================================================== -->

    <aside
        class="fixed left-0 top-0 h-screen w-64 bg-purple-800 text-white"
    >

        <!-- Logo -->

        <div class="px-6 py-7 border-b border-purple-700">

            <h1 class="text-2xl font-bold">
                Rei do Açaí
            </h1>

            <p class="text-purple-200 text-sm mt-1">
                Painel administrativo
            </p>

        </div>


        <!-- Menu -->

        <nav class="px-4 py-5">


            <!-- Início -->

            <a
                href="index.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition duration-200 mb-2"
            >

                <span class="text-lg">🏠</span>

                <span>
                    Início
                </span>

            </a>


            <!-- Produtos -->

            <a
                href="produtos.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition duration-200 mb-2"
            >

                <span class="text-lg">📦</span>

                <span>
                    Produtos
                </span>

            </a>


            <!-- Adicionais -->

            <a
                href="adicionais.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition duration-200 mb-2"
            >

                <span class="text-lg">🥣</span>

                <span>
                    Adicionais
                </span>

            </a>


            <!-- Pedidos -->

            <a
                href="pedidos.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition duration-200 mb-2"
            >

                <span class="text-lg">🧾</span>

                <span>
                    Pedidos
                </span>

            </a>


            <!-- Clientes -->

            <a
                href="clientes.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition duration-200 mb-2"
            >

                <span class="text-lg">👥</span>

                <span>
                    Clientes
                </span>

            </a>


            <!-- Relatórios -->

            <a
                href="relatorio.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg bg-purple-700 mb-2"
            >

                <span class="text-lg">📊</span>

                <span>
                    Relatórios
                </span>

            </a>


        </nav>


        <!-- Voltar para o site -->

        <div
            class="absolute bottom-0 left-0 w-full p-4 border-t border-purple-700"
        >

            <a
                href="../index.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition"
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



    <!-- ==================================================
         CONTEÚDO
    =================================================== -->

    <main class="ml-64 p-8">


        <!-- Cabeçalho -->

        <div class="mb-8">

            <p class="text-sm text-purple-700 font-medium mb-1">
                Visão geral
            </p>

            <h2 class="text-3xl font-bold text-gray-800">
                Dashboard
            </h2>

            <p class="text-gray-500 mt-1">
                Acompanhe os principais dados do Rei do Açaí.
            </p>

        </div>



        <!-- ==================================================
             CARDS
        =================================================== -->

        <div
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5 mb-8"
        >


            <!-- Clientes -->

            <div
                class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5"
            >

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-gray-500">
                            Clientes
                        </p>

                        <p class="text-2xl font-bold text-gray-800 mt-1">
                            <?php echo $total_clientes; ?>
                        </p>

                    </div>

                    <div
                        class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-xl"
                    >
                        👥
                    </div>

                </div>

            </div>



            <!-- Pedidos -->

            <div
                class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5"
            >

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-gray-500">
                            Pedidos
                        </p>

                        <p class="text-2xl font-bold text-gray-800 mt-1">
                            <?php echo $total_pedidos; ?>
                        </p>

                    </div>

                    <div
                        class="w-11 h-11 rounded-xl bg-purple-50 flex items-center justify-center text-xl"
                    >
                        🧾
                    </div>

                </div>

            </div>



            <!-- Vendas -->

            <div
                class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5"
            >

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-gray-500">
                            Vendas
                        </p>

                        <p class="text-2xl font-bold text-gray-800 mt-1">

                            R$
                            <?php
                            echo number_format(
                                $total_vendas,
                                2,
                                ",",
                                "."
                            );
                            ?>

                        </p>

                    </div>

                    <div
                        class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center text-xl"
                    >
                        💰
                    </div>

                </div>

            </div>



            <!-- Produtos -->

            <div
                class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5"
            >

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-gray-500">
                            Produtos
                        </p>

                        <p class="text-2xl font-bold text-gray-800 mt-1">
                            <?php echo $total_produtos; ?>
                        </p>

                    </div>

                    <div
                        class="w-11 h-11 rounded-xl bg-orange-50 flex items-center justify-center text-xl"
                    >
                        📦
                    </div>

                </div>

            </div>



            <!-- Adicionais -->

            <div
                class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5"
            >

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-gray-500">
                            Adicionais
                        </p>

                        <p class="text-2xl font-bold text-gray-800 mt-1">
                            <?php echo $total_adicionais; ?>
                        </p>

                    </div>

                    <div
                        class="w-11 h-11 rounded-xl bg-pink-50 flex items-center justify-center text-xl"
                    >
                        🥣
                    </div>

                </div>

            </div>


        </div>



        <!-- ==================================================
             GRÁFICOS
        =================================================== -->

        <div
            class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8"
        >


            <!-- Status dos pedidos -->

            <div
                class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6"
            >

                <div class="mb-5">

                    <h3 class="text-lg font-semibold text-gray-800">
                        Status dos pedidos
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Distribuição dos pedidos por situação.
                    </p>

                </div>


                <div class="relative h-72">

                    <canvas id="graficoStatus"></canvas>

                </div>

            </div>



            <!-- Produtos mais vendidos -->

            <div
                class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6"
            >

                <div class="mb-5">

                    <h3 class="text-lg font-semibold text-gray-800">
                        Produtos mais vendidos
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Os produtos com maior quantidade vendida.
                    </p>

                </div>


                <div class="relative h-72">

                    <canvas id="graficoProdutos"></canvas>

                </div>

            </div>


        </div>



        <!-- ==================================================
             STATUS RESUMIDO
        =================================================== -->

        <div
            class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-8"
        >

            <h3 class="text-lg font-semibold text-gray-800">
                Resumo dos pedidos
            </h3>

            <p class="text-sm text-gray-500 mt-1 mb-5">
                Quantidade de pedidos em cada etapa.
            </p>


            <div
                class="grid grid-cols-2 md:grid-cols-5 gap-4"
            >


                <div class="bg-yellow-50 rounded-xl p-4">

                    <p class="text-sm text-yellow-700">
                        Recebidos
                    </p>

                    <p class="text-2xl font-bold text-yellow-800 mt-1">

                        <?php echo $status_pedidos["Recebido"]; ?>

                    </p>

                </div>


                <div class="bg-blue-50 rounded-xl p-4">

                    <p class="text-sm text-blue-700">
                        Em preparo
                    </p>

                    <p class="text-2xl font-bold text-blue-800 mt-1">

                        <?php echo $status_pedidos["Em preparo"]; ?>

                    </p>

                </div>


                <div class="bg-purple-50 rounded-xl p-4">

                    <p class="text-sm text-purple-700">
                        Saiu para entrega
                    </p>

                    <p class="text-2xl font-bold text-purple-800 mt-1">

                        <?php echo $status_pedidos["Saiu para entrega"]; ?>

                    </p>

                </div>


                <div class="bg-green-50 rounded-xl p-4">

                    <p class="text-sm text-green-700">
                        Entregues
                    </p>

                    <p class="text-2xl font-bold text-green-800 mt-1">

                        <?php echo $status_pedidos["Entregue"]; ?>

                    </p>

                </div>


                <div class="bg-red-50 rounded-xl p-4">

                    <p class="text-sm text-red-700">
                        Cancelados
                    </p>

                    <p class="text-2xl font-bold text-red-800 mt-1">

                        <?php echo $status_pedidos["Cancelado"]; ?>

                    </p>

                </div>


            </div>

        </div>



        <!-- ==================================================
             ÚLTIMOS PEDIDOS
        =================================================== -->

        <div
            class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden"
        >

            <div class="p-6 border-b border-gray-100">

                <h3 class="text-lg font-semibold text-gray-800">
                    Últimos pedidos
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Pedidos mais recentes registrados no sistema.
                </p>

            </div>


            <?php if (count($ultimos_pedidos) > 0): ?>


                <div class="overflow-x-auto">

                    <table class="w-full text-sm">

                        <thead class="bg-gray-50">

                            <tr>

                                <th class="text-left px-6 py-4 font-semibold text-gray-600">
                                    Pedido
                                </th>

                                <th class="text-left px-6 py-4 font-semibold text-gray-600">
                                    Cliente
                                </th>

                                <th class="text-left px-6 py-4 font-semibold text-gray-600">
                                    Data
                                </th>

                                <th class="text-left px-6 py-4 font-semibold text-gray-600">
                                    Status
                                </th>

                                <th class="text-right px-6 py-4 font-semibold text-gray-600">
                                    Total
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-gray-100">

                            <?php foreach ($ultimos_pedidos as $pedido): ?>

                                <tr class="hover:bg-gray-50 transition">


                                    <td class="px-6 py-4 font-medium text-gray-800">

                                        #<?php echo $pedido["ID_PED"]; ?>

                                    </td>


                                    <td class="px-6 py-4 text-gray-600">

                                        <?php echo htmlspecialchars($pedido["NOME_CLI"]); ?>

                                    </td>


                                    <td class="px-6 py-4 text-gray-500">

                                        <?php

                                        if (!empty($pedido["DATA_PED"])) {

                                            echo date(
                                                "d/m/Y H:i",
                                                strtotime($pedido["DATA_PED"])
                                            );

                                        } else {

                                            echo "-";

                                        }

                                        ?>

                                    </td>


                                    <td class="px-6 py-4">

                                        <span
                                            class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700"
                                        >

                                            <?php
                                            echo htmlspecialchars(
                                                $pedido["STATUS_PED"]
                                            );
                                            ?>

                                        </span>

                                    </td>


                                    <td class="px-6 py-4 text-right font-semibold text-gray-800">

                                        R$

                                        <?php

                                        echo number_format(
                                            $pedido["VALOR_TOTAL"],
                                            2,
                                            ",",
                                            "."
                                        );

                                        ?>

                                    </td>


                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>


            <?php else: ?>


                <div class="p-12 text-center">

                    <div
                        class="w-14 h-14 mx-auto rounded-full bg-purple-50 flex items-center justify-center text-2xl mb-4"
                    >
                        📊
                    </div>

                    <h4 class="font-semibold text-gray-800">
                        Ainda não existem pedidos
                    </h4>

                    <p class="text-sm text-gray-500 mt-1">
                        Assim que os clientes realizarem pedidos,
                        os dados aparecerão aqui.
                    </p>

                </div>


            <?php endif; ?>


        </div>


    </main>



    <!-- ==================================================
         DADOS PARA O JAVASCRIPT
    =================================================== -->

    <script>

        const dadosStatus = <?php echo json_encode($dados_status); ?>;

        const dadosProdutos = <?php echo json_encode($produtos_vendidos); ?>;

    </script>


    <!-- JavaScript do dashboard -->

    <script src="../js/relatorios.js"></script>


</body>

</html>