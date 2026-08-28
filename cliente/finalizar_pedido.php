<?php

session_start();

if (!isset($_SESSION["ID_CLI"]) || $_SESSION["ID_CLI"] == 1) {
    header("Location: ../loginusuario.php");
    exit;
}

require_once "../config/conexao.php";

$id_cli = $_SESSION["ID_CLI"];

/*
|--------------------------------------------------------------------------
| BUSCAR DADOS DO CLIENTE E ENDEREÇO
|--------------------------------------------------------------------------
*/

$sql_cliente = "SELECT 
                    c.NOME_CLI,
                    c.EMAIL_CLI,
                    e.RUA,
                    e.NUMERO,
                    e.BAIRRO,
                    e.CIDADE,
                    e.ESTADO,
                    e.CEP,
                    e.COMPLEMENTO
                FROM CLIENTE c
                LEFT JOIN ENDERECO e ON c.COD_END = e.ID_END
                WHERE c.ID_CLI = ?";

$stmt_cliente = $conexao->prepare($sql_cliente);
$stmt_cliente->bind_param("i", $id_cli);
$stmt_cliente->execute();

$resultado_cliente = $stmt_cliente->get_result();
$cliente = $resultado_cliente->fetch_assoc();

$stmt_cliente->close();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Finalizar Pedido | Rei do Açaí</title>

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
                class="hover:text-yellow-300 transition">

                🛒 Carrinho

            </a>


            <a
                href="pedidos.php"
                class="hover:text-yellow-300 transition">

                Meus pedidos

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

            Finalizar pedido

        </h1>


        <p class="mt-2 text-purple-100">

            Confira seus dados antes de confirmar o pedido.

        </p>

    </div>

</section>


<!-- =========================================================
     CONTEÚDO
========================================================= -->

<main class="max-w-7xl mx-auto px-6 py-10">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">


        <!-- =================================================
             DADOS DA ENTREGA
        ================================================== -->

        <section class="lg:col-span-2 space-y-6">


            <!-- ENDEREÇO -->

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

                <h2 class="text-2xl font-bold mb-6">

                    Endereço de entrega

                </h2>


                <?php if ($cliente && !empty($cliente["RUA"])): ?>

                    <div class="bg-gray-50 rounded-xl p-5">

                        <p class="font-semibold text-lg">

                            <?php echo htmlspecialchars($cliente["NOME_CLI"] ?? ""); ?>

                        </p>


                        <p class="text-gray-600 mt-2">

                            <?php echo htmlspecialchars($cliente["RUA"]); ?>,
                            <?php echo htmlspecialchars($cliente["NUMERO"]); ?>

                        </p>


                        <p class="text-gray-600">

                            <?php echo htmlspecialchars($cliente["BAIRRO"]); ?> -
                            <?php echo htmlspecialchars($cliente["CIDADE"]); ?>/<?php echo htmlspecialchars($cliente["ESTADO"]); ?>

                        </p>


                        <p class="text-gray-600">

                            CEP:
                            <?php echo htmlspecialchars($cliente["CEP"]); ?>

                        </p>


                        <?php if (!empty($cliente["COMPLEMENTO"])): ?>

                            <p class="text-gray-600">

                                Complemento:
                                <?php echo htmlspecialchars($cliente["COMPLEMENTO"]); ?>

                            </p>

                        <?php endif; ?>

                    </div>

                <?php else: ?>

                    <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-xl p-5">

                        <p class="font-semibold">

                            Você ainda não possui um endereço cadastrado.

                        </p>


                        <p class="text-sm mt-1">

                            Cadastre um endereço antes de finalizar o pedido.

                        </p>

                    </div>

                <?php endif; ?>

            </div>


            <!-- PAGAMENTO -->

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

                <h2 class="text-2xl font-bold mb-6">

                    Forma de pagamento

                </h2>


                <form
                    id="formFinalizarPedido"
                    action="../processa/criar_pedido.php"
                    method="POST">


                    <div class="space-y-3">


                        <label class="flex items-center gap-3 border border-gray-200 rounded-xl p-4 cursor-pointer hover:bg-gray-50">

                            <input
                                type="radio"
                                name="metodo_pag"
                                value="Pix"
                                required>

                            <span class="font-medium">

                                PIX

                            </span>

                        </label>


                        <label class="flex items-center gap-3 border border-gray-200 rounded-xl p-4 cursor-pointer hover:bg-gray-50">

                            <input
                                type="radio"
                                name="metodo_pag"
                                value="Dinheiro"
                                required>

                            <span class="font-medium">

                                Dinheiro

                            </span>

                        </label>


                        <label class="flex items-center gap-3 border border-gray-200 rounded-xl p-4 cursor-pointer hover:bg-gray-50">

                            <input
                                type="radio"
                                name="metodo_pag"
                                value="Cartão"
                                required>

                            <span class="font-medium">

                                Cartão

                            </span>

                        </label>


                    </div>


                    <input
                        type="hidden"
                        name="confirmar"
                        value="1">


                    <button
                        type="submit"
                        class="mt-6 w-full bg-purple-700 text-white py-4 rounded-xl font-bold text-lg hover:bg-purple-800 transition">

                        Confirmar pedido

                    </button>


                </form>

            </div>

        </section>


        <!-- =================================================
             RESUMO DO PEDIDO
        ================================================== -->

        <aside>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">


                <h2 class="text-xl font-bold mb-6">

                    Resumo do pedido

                </h2>


                <!-- JavaScript vai preencher -->

                <div id="resumoProdutos" class="space-y-4">

                </div>


                <div class="border-t border-gray-200 mt-6 pt-5 space-y-3">


                    <div class="flex justify-between text-gray-600">

                        <span>

                            Produtos

                        </span>


                        <span id="subtotalProdutos">

                            R$ 0,00

                        </span>

                    </div>


                    <div class="flex justify-between text-gray-600">

                        <span>

                            Adicionais

                        </span>


                        <span id="subtotalAdicionais">

                            R$ 0,00

                        </span>

                    </div>


                    <div class="border-t border-gray-200 pt-4 flex justify-between items-center">

                        <span class="text-lg font-bold">

                            Total

                        </span>


                        <span
                            id="totalPedido"
                            class="text-2xl font-bold text-purple-700">

                            R$ 0,00

                        </span>

                    </div>

                </div>


                <a
                    href="carrinho.php"
                    class="block text-center mt-6 text-purple-700 font-semibold hover:text-purple-900">

                    ← Voltar para o carrinho

                </a>

            </div>

        </aside>

    </div>

</main>


<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script src="../js/finalizar_pedido.js"></script>


</body>

</html>