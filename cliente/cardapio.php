<?php

require_once "../config/conexao.php";

$categoria = $_GET["categoria"] ?? "Todos";


/*
|--------------------------------------------------------------------------
| BUSCAR PRODUTOS
|--------------------------------------------------------------------------
*/

if ($categoria === "Todos") {

    $sql_produtos = "
        SELECT
            ID_PROD,
            NOME_PROD,
            TIPO_PROD,
            VALOR_PROD,
            ESTOQUE,
            IMAGEM
        FROM PRODUTO
        WHERE ESTOQUE > 0
        ORDER BY ID_PROD DESC
    ";

    $stmt_produtos = $conexao->prepare($sql_produtos);

} else {

    $sql_produtos = "
        SELECT
            ID_PROD,
            NOME_PROD,
            TIPO_PROD,
            VALOR_PROD,
            ESTOQUE,
            IMAGEM
        FROM PRODUTO
        WHERE ESTOQUE > 0
        AND TIPO_PROD = ?
        ORDER BY ID_PROD DESC
    ";

    $stmt_produtos = $conexao->prepare($sql_produtos);

    $stmt_produtos->bind_param(
        "s",
        $categoria
    );
}


$stmt_produtos->execute();

$resultado_produtos =
    $stmt_produtos->get_result();


/*
|--------------------------------------------------------------------------
| BUSCAR ADICIONAIS
|--------------------------------------------------------------------------
*/

$sql_adicionais = "
    SELECT
        ID_ADC,
        NOME_ADC,
        TIPO_ADC,
        VALOR_ADC,
        ESTOQUE,
        IMAGEM
    FROM ADICIONAL
    WHERE ESTOQUE > 0
    ORDER BY NOME_ADC ASC
";

$resultado_adicionais =
    $conexao->query($sql_adicionais);

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Cardápio | Rei do Açaí</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-gray-100 text-gray-800">


<!-- =========================================================
     CABEÇALHO
========================================================= -->

<header class="bg-purple-800 text-white">

    <div
        class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">


        <a
            href="../index.php"
            class="text-3xl font-bold">

            Rei do Açaí

        </a>


        <nav class="flex items-center gap-6">

            <a
                href="../index.php"
                class="hover:text-yellow-300 transition">

                Início

            </a>


            <a
                href="carrinho.php"
                class="hover:text-yellow-300 transition">

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

<section class="bg-purple-700 text-white py-12">

    <div class="max-w-7xl mx-auto px-6">

        <p class="text-purple-200 mb-2">

            Rei do Açaí

        </p>


        <h1 class="text-4xl font-bold">

            Cardápio

        </h1>


        <p class="mt-2 text-purple-100">

            Escolha seu açaí e personalize do seu jeito.

        </p>

    </div>

</section>


<!-- =========================================================
     FILTROS
========================================================= -->

<section class="max-w-7xl mx-auto px-6 py-8">

    <div class="flex flex-wrap gap-3">

        <a
            href="cardapio.php"
            class="px-5 py-2 rounded-lg bg-white shadow hover:bg-purple-100 transition">

            Todos

        </a>


        <a
            href="cardapio.php?categoria=Copo"
            class="px-5 py-2 rounded-lg bg-white shadow hover:bg-purple-100 transition">

            Copos

        </a>


        <a
            href="cardapio.php?categoria=Pote"
            class="px-5 py-2 rounded-lg bg-white shadow hover:bg-purple-100 transition">

            Potes

        </a>

    </div>

</section>


<!-- =========================================================
     PRODUTOS
========================================================= -->

<main class="max-w-7xl mx-auto px-6 pb-16">


    <?php if ($resultado_produtos->num_rows > 0): ?>


        <div
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">


            <?php while ($produto = $resultado_produtos->fetch_assoc()): ?>


                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition">


                    <!-- IMAGEM -->

                    <div
                        class="h-56 bg-gray-100 flex items-center justify-center overflow-hidden">


                        <?php if (!empty($produto["IMAGEM"])): ?>


                            <img
                                src="../<?php echo htmlspecialchars($produto["IMAGEM"]); ?>"
                                alt="<?php echo htmlspecialchars($produto["NOME_PROD"]); ?>"
                                class="w-full h-full object-contain">


                        <?php else: ?>


                            <span class="text-gray-400">

                                Sem imagem

                            </span>


                        <?php endif; ?>


                    </div>


                    <!-- INFORMAÇÕES -->

                    <div class="p-5">


                        <p
                            class="text-sm text-gray-500 mb-1">

                            <?php echo htmlspecialchars($produto["TIPO_PROD"]); ?>

                        </p>


                        <h2 class="text-xl font-bold">

                            <?php echo htmlspecialchars($produto["NOME_PROD"]); ?>

                        </h2>


                        <p
                            class="text-purple-700 text-xl font-bold mt-2">

                            R$

                            <?php echo number_format(
                                $produto["VALOR_PROD"],
                                2,
                                ",",
                                "."
                            ); ?>

                        </p>


                        <p
                            class="text-sm text-gray-500 mt-2">

                            <?php echo $produto["ESTOQUE"]; ?>

                            unidades disponíveis

                        </p>


                        <!-- BOTÃO -->

                        <button
                            type="button"
                            class="btn-produto mt-4 w-full bg-purple-700 text-white py-3 rounded-lg font-semibold hover:bg-purple-800 transition"

                            data-id="<?php echo $produto["ID_PROD"]; ?>"

                            data-nome="<?php echo htmlspecialchars($produto["NOME_PROD"]); ?>"

                            data-preco="<?php echo $produto["VALOR_PROD"]; ?>"

                            data-imagem="<?php echo htmlspecialchars($produto["IMAGEM"]); ?>"

                            data-estoque="<?php echo $produto["ESTOQUE"]; ?>">

                            Personalizar

                        </button>


                    </div>

                </div>


            <?php endwhile; ?>


        </div>


    <?php else: ?>


        <div
            class="bg-white rounded-2xl shadow p-12 text-center">


            <div class="text-5xl mb-4">

                🍧

            </div>


            <h2 class="text-2xl font-bold">

                Nenhum produto encontrado

            </h2>


            <p class="text-gray-500 mt-2">

                Não existem produtos disponíveis nessa categoria.

            </p>


        </div>


    <?php endif; ?>


</main>


<!-- =========================================================
     MODAL DE PERSONALIZAÇÃO
========================================================= -->

<div
    id="modalProduto"
    class="hidden fixed inset-0 bg-black/50 flex items-center justify-center px-4 z-50">


    <div
        class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6">


        <!-- CABEÇALHO -->

        <div
            class="flex justify-between items-center mb-6">


            <div>

                <h2
                    id="modalNome"
                    class="text-2xl font-bold">

                    Produto

                </h2>


                <p
                    id="modalPreco"
                    class="text-purple-700 font-bold mt-1">

                    R$ 0,00

                </p>

            </div>


            <button
                id="fecharModal"
                type="button"
                class="text-gray-500 text-3xl hover:text-gray-800">

                &times;

            </button>

        </div>


        <!-- =================================================
             ADICIONAIS
        ================================================== -->

        <div>

            <h3
                class="text-lg font-bold mb-4">

                Escolha seus adicionais

            </h3>


            <div
                class="grid grid-cols-1 sm:grid-cols-2 gap-3">


                <?php while ($adicional = $resultado_adicionais->fetch_assoc()): ?>


                    <label
                        class="flex items-center justify-between gap-3 border border-gray-200 rounded-xl p-4 cursor-pointer hover:border-purple-500 hover:bg-purple-50 transition">


                        <div
                            class="flex items-center gap-3">


                            <input
                                type="checkbox"
                                class="adicional-checkbox w-5 h-5 accent-purple-700"

                                data-id="<?php echo $adicional["ID_ADC"]; ?>"

                                data-nome="<?php echo htmlspecialchars($adicional["NOME_ADC"]); ?>"

                                data-preco="<?php echo $adicional["VALOR_ADC"]; ?>">


                            <div>

                                <p class="font-medium">

                                    <?php echo htmlspecialchars($adicional["NOME_ADC"]); ?>

                                </p>


                                <p
                                    class="text-xs text-gray-500">

                                    <?php echo htmlspecialchars($adicional["TIPO_ADC"] ?? ""); ?>

                                </p>

                            </div>

                        </div>


                        <span
                            class="font-semibold text-purple-700">


                            <?php if ($adicional["VALOR_ADC"] > 0): ?>


                                + R$

                                <?php echo number_format(
                                    $adicional["VALOR_ADC"],
                                    2,
                                    ",",
                                    "."
                                ); ?>


                            <?php else: ?>


                                Grátis


                            <?php endif; ?>


                        </span>


                    </label>


                <?php endwhile; ?>


            </div>

        </div>


        <!-- =================================================
             QUANTIDADE
        ================================================== -->

        <div
            class="border-t border-gray-200 mt-6 pt-6">


            <h3 class="font-bold mb-3">

                Quantidade

            </h3>


            <div
                class="flex items-center gap-4">


                <button
                    id="diminuirQuantidade"
                    type="button"
                    class="w-10 h-10 rounded-lg bg-gray-200 text-xl hover:bg-gray-300">

                    -

                </button>


                <span
                    id="quantidadeProduto"
                    class="text-xl font-bold">

                    1

                </span>


                <button
                    id="aumentarQuantidade"
                    type="button"
                    class="w-10 h-10 rounded-lg bg-purple-700 text-white text-xl hover:bg-purple-800">

                    +

                </button>

            </div>

        </div>


        <!-- =================================================
             LIMITE DE ADICIONAIS
        ================================================== -->

        <div
            class="mt-6 bg-purple-50 rounded-lg p-4 text-sm text-purple-800">


            Você possui

            <strong id="limiteGratis">

                0

            </strong>

            adicionais grátis.


            <br>


            Adicionais selecionados:

            <strong id="contadorAdicionais">

                0

            </strong>

            /

            <strong id="limiteAdicionais">

                0

            </strong>

        </div>


        <!-- =================================================
             RESUMO
        ================================================== -->

        <div
            class="border-t border-gray-200 mt-6 pt-6">


            <div
                class="flex justify-between mb-2">


                <span>

                    Produto

                </span>


                <span id="resumoProduto">

                    R$ 0,00

                </span>

            </div>


            <div
                class="flex justify-between mb-3">


                <span>

                    Adicionais

                </span>


                <span id="resumoAdicionais">

                    R$ 0,00

                </span>

            </div>


            <div
                class="border-t border-gray-200 pt-4 flex justify-between items-center">


                <span
                    class="text-lg font-semibold">

                    Total

                </span>


                <span
                    id="totalProduto"
                    class="text-2xl font-bold text-purple-700">

                    R$ 0,00

                </span>

            </div>

        </div>


        <!-- =================================================
             BOTÃO
        ================================================== -->

        <button
            id="adicionarCarrinho"
            type="button"
            class="mt-6 w-full bg-purple-700 text-white py-3 rounded-lg font-bold hover:bg-purple-800 transition">

            Adicionar ao carrinho

        </button>


    </div>

</div>


<!-- JAVASCRIPT -->

<script src="../js/cardapio.js"></script>


</body>

</html>


<?php

$stmt_produtos->close();

$conexao->close();

?>