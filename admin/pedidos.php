<?php

session_start();

// Verifica se o usuário é o administrador
if (!isset($_SESSION["ID_CLI"]) || $_SESSION["ID_CLI"] != 1) {
    header("Location: ../loginusuario.php");
    exit;
}

require_once "../config/conexao.php";

// Status permitidos para os pedidos
$status_disponiveis = [
    "Recebido",
    "Em preparo",
    "Saiu para entrega",
    "Entregue",
    "Cancelado"
];

// Mensagens
$mensagem_sucesso = null;
$mensagem_erro = null;

if (isset($_GET["status"]) && $_GET["status"] === "sucesso") {
    $mensagem_sucesso = "Status do pedido atualizado com sucesso!";
}

$erros = [
    "statusinvalido" => "Status inválido.",
    "pedidoinvalido" => "Pedido inválido.",
    "erro" => "Não foi possível atualizar o pedido."
];

if (isset($_GET["erro"]) && isset($erros[$_GET["erro"]])) {
    $mensagem_erro = $erros[$_GET["erro"]];
}


// Busca os pedidos
$sql_pedidos = "
    SELECT
        p.ID_PED,
        p.STATUS_PED,
        p.METODO_PAG,
        p.VALOR_TOTAL,
        p.DATA_PED,

        c.NOME_CLI,

        e.RUA,
        e.NUMERO,
        e.BAIRRO,
        e.CIDADE

    FROM PEDIDO p

    INNER JOIN CLIENTE c
        ON p.COD_CLI = c.ID_CLI

    INNER JOIN ENDERECO e
        ON p.COD_END = e.ID_END

    ORDER BY p.DATA_PED DESC
";

$pedidos = $conexao->query($sql_pedidos);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pedidos | Rei do Açaí</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-gray-100 min-h-screen">


    <!-- MENU LATERAL -->

    <aside class="fixed left-0 top-0 h-screen w-64 bg-purple-800 text-white">

        <!-- Cabeçalho -->

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

            <a
                href="index.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition mb-2"
            >
                <span class="text-lg">🏠</span>
                <span>Início</span>
            </a>


            <a
                href="produtos.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition mb-2"
            >
                <span class="text-lg">📦</span>
                <span>Produtos</span>
            </a>


            <a
                href="adicionais.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition mb-2"
            >
                <span class="text-lg">🥣</span>
                <span>Adicionais</span>
            </a>


            <!-- Página atual -->

            <a
                href="pedidos.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg bg-purple-700 mb-2"
            >
                <span class="text-lg">🧾</span>
                <span>Pedidos</span>
            </a>


            <a
                href="clientes.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition mb-2"
            >
                <span class="text-lg">👥</span>
                <span>Clientes</span>
            </a>


            <a
                href="relatorio.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition mb-2"
            >
                <span class="text-lg">📊</span>
                <span>Relatórios</span>
            </a>

        </nav>


        <!-- Voltar para o site -->

        <div class="absolute bottom-0 left-0 w-full p-4 border-t border-purple-700">

            <a
                href="../index.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition"
            >
                <span class="text-lg">←</span>
                <span>Voltar para o site</span>
            </a>

        </div>

    </aside>



    <!-- CONTEÚDO PRINCIPAL -->

    <main class="ml-64 p-8">


        <!-- Cabeçalho da página -->

        <div class="mb-8">

            <p class="text-sm text-purple-700 font-medium mb-1">
                Gerenciamento
            </p>

            <h2 class="text-3xl font-bold text-gray-800">
                Pedidos
            </h2>

            <p class="text-gray-500 mt-1">
                Acompanhe e atualize os pedidos realizados pelos clientes.
            </p>

        </div>



        <!-- MENSAGEM DE SUCESSO -->

        <?php if ($mensagem_sucesso): ?>

            <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 mb-6">

                <?php echo htmlspecialchars($mensagem_sucesso); ?>

            </div>

        <?php endif; ?>



        <!-- MENSAGEM DE ERRO -->

        <?php if ($mensagem_erro): ?>

            <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-6">

                <?php echo htmlspecialchars($mensagem_erro); ?>

            </div>

        <?php endif; ?>



        <!-- LISTAGEM DOS PEDIDOS -->

        <?php if ($pedidos && $pedidos->num_rows > 0): ?>


            <div class="space-y-5">


                <?php while ($pedido = $pedidos->fetch_assoc()): ?>


                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">


                        <!-- INFORMAÇÕES PRINCIPAIS -->

                        <div class="flex flex-wrap justify-between gap-5 mb-5">


                            <div>

                                <div class="flex items-center gap-3">

                                    <h3 class="text-lg font-semibold text-gray-800">

                                        Pedido #<?php echo $pedido["ID_PED"]; ?>

                                    </h3>

                                    <span class="text-sm text-gray-500">

                                        <?php echo htmlspecialchars($pedido["NOME_CLI"]); ?>

                                    </span>

                                </div>


                                <p class="text-sm text-gray-500 mt-2">

                                    <?php

                                    if (!empty($pedido["DATA_PED"])) {

                                        echo date(
                                            "d/m/Y H:i",
                                            strtotime($pedido["DATA_PED"])
                                        );

                                    } else {

                                        echo "Data não informada";

                                    }

                                    ?>

                                    <span class="mx-1">•</span>

                                    <?php echo htmlspecialchars($pedido["METODO_PAG"]); ?>

                                </p>


                                <p class="text-sm text-gray-500 mt-2">

                                    📍

                                    <?php echo htmlspecialchars($pedido["RUA"]); ?>,
                                    <?php echo htmlspecialchars($pedido["NUMERO"]); ?>

                                    —

                                    <?php echo htmlspecialchars($pedido["BAIRRO"]); ?>,
                                    <?php echo htmlspecialchars($pedido["CIDADE"]); ?>

                                </p>

                            </div>



                            <!-- ALTERAÇÃO DO STATUS -->

                            <form
                                action="../processa/atualizar_status_pedido.php"
                                method="POST"
                                class="flex items-center gap-2"
                            >

                                <input
                                    type="hidden"
                                    name="id_ped"
                                    value="<?php echo $pedido["ID_PED"]; ?>"
                                >


                                <select
                                    name="status_ped"
                                    class="border border-gray-300 bg-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                                >

                                    <?php foreach ($status_disponiveis as $status): ?>

                                        <option
                                            value="<?php echo htmlspecialchars($status); ?>"
                                            <?php
                                            echo ($pedido["STATUS_PED"] === $status)
                                                ? "selected"
                                                : "";
                                            ?>
                                        >

                                            <?php echo htmlspecialchars($status); ?>

                                        </option>

                                    <?php endforeach; ?>

                                </select>


                                <button
                                    type="submit"
                                    class="bg-purple-700 hover:bg-purple-800 text-white text-sm font-medium px-4 py-2 rounded-lg transition"
                                >

                                    Atualizar

                                </button>

                            </form>

                        </div>



                        <!-- ITENS DO PEDIDO -->

                        <?php

                        $stmt_itens = $conexao->prepare("
                            SELECT
                                i.QUANTIDADE,
                                i.SUBTOTAL,
                                pr.NOME_PROD,
                                ad.NOME_ADC

                            FROM ITEM_PEDIDO i

                            INNER JOIN PRODUTO pr
                                ON i.COD_PROD = pr.ID_PROD

                            LEFT JOIN ADICIONAL ad
                                ON i.COD_ADC = ad.ID_ADC

                            WHERE i.COD_PED = ?
                        ");

                        ?>


                        <?php if ($stmt_itens): ?>


                            <?php

                            $stmt_itens->bind_param(
                                "i",
                                $pedido["ID_PED"]
                            );

                            $stmt_itens->execute();


                            // Inicialização das variáveis
                            // Evita avisos do editor

                            $qtd_item = 0;
                            $subtotal_item = 0;
                            $nome_prod_item = "";
                            $nome_adc_item = "";


                            $stmt_itens->bind_result(
                                $qtd_item,
                                $subtotal_item,
                                $nome_prod_item,
                                $nome_adc_item
                            );

                            ?>


                            <div class="border-t border-gray-100 pt-4 space-y-2">


                                <?php

                                $possui_itens = false;

                                while ($stmt_itens->fetch()):

                                    $possui_itens = true;

                                ?>

                                    <div class="flex items-center justify-between gap-4">

                                        <p class="text-sm text-gray-600">

                                            <span class="font-medium text-gray-800">

                                                <?php echo $qtd_item; ?>x

                                            </span>

                                            <?php echo htmlspecialchars($nome_prod_item); ?>


                                            <?php if (!empty($nome_adc_item)): ?>

                                                <span class="text-purple-600">

                                                    + <?php echo htmlspecialchars($nome_adc_item); ?>

                                                </span>

                                            <?php endif; ?>

                                        </p>


                                        <span class="text-sm font-medium text-gray-700 whitespace-nowrap">

                                            R$

                                            <?php

                                            echo number_format(
                                                $subtotal_item,
                                                2,
                                                ",",
                                                "."
                                            );

                                            ?>

                                        </span>

                                    </div>

                                <?php endwhile; ?>


                                <?php if (!$possui_itens): ?>

                                    <p class="text-sm text-gray-400">

                                        Nenhum item encontrado neste pedido.

                                    </p>

                                <?php endif; ?>


                            </div>


                            <?php $stmt_itens->close(); ?>


                        <?php else: ?>


                            <p class="text-sm text-red-500 border-t border-gray-100 pt-4">

                                Não foi possível carregar os itens deste pedido.

                            </p>


                        <?php endif; ?>



                        <!-- TOTAL E STATUS -->

                        <div class="border-t border-gray-100 mt-5 pt-4 flex items-center justify-between gap-4">


                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700"
                            >

                                <?php echo htmlspecialchars($pedido["STATUS_PED"]); ?>

                            </span>


                            <span class="text-lg font-bold text-gray-800">

                                Total:

                                R$

                                <?php

                                echo number_format(
                                    $pedido["VALOR_TOTAL"],
                                    2,
                                    ",",
                                    "."
                                );

                                ?>

                            </span>

                        </div>


                    </div>


                <?php endwhile; ?>


            </div>


        <?php else: ?>


            <!-- NENHUM PEDIDO -->

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-16 text-center">


                <div class="w-16 h-16 mx-auto flex items-center justify-center bg-purple-50 rounded-full text-3xl mb-4">

                    🧾

                </div>


                <h3 class="text-lg font-semibold text-gray-800">

                    Nenhum pedido recebido ainda

                </h3>


                <p class="text-gray-500 text-sm mt-2 max-w-md mx-auto">

                    Assim que um cliente realizar um pedido pelo sistema,
                    ele aparecerá automaticamente nesta área.

                </p>


            </div>


        <?php endif; ?>


    </main>


</body>

</html>