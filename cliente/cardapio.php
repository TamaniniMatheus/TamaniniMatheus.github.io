```php
<?php

require_once "../config/conexao.php";

$categoria = $_GET["categoria"] ?? "Todos";

if ($categoria === "Todos") {

    $sql = "SELECT ID_PROD, NOME_PROD, TIPO_PROD, VALOR_PROD, ESTOQUE, IMAGEM
            FROM PRODUTO
            WHERE ESTOQUE > 0
            ORDER BY ID_PROD DESC";

    $stmt = $conexao->prepare($sql);

} else {

    $sql = "SELECT ID_PROD, NOME_PROD, TIPO_PROD, VALOR_PROD, ESTOQUE, IMAGEM
            FROM PRODUTO
            WHERE ESTOQUE > 0
            AND TIPO_PROD = ?
            ORDER BY ID_PROD DESC";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param("s", $categoria);
}

$stmt->execute();

$resultado = $stmt->get_result();

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cardápio | Rei do Açaí</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-gray-100 text-gray-800">


<!-- CABEÇALHO -->

<header class="bg-purple-800 text-white">

    <div class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">

        <a href="../index.php"
           class="text-3xl font-bold">

            Rei do Açaí

        </a>


        <nav class="flex items-center gap-6">

            <a href="../index.php"
               class="hover:text-yellow-300">

                Início

            </a>

            <a href="carrinho.php"
               class="hover:text-yellow-300">

                🛒 Carrinho

            </a>

            <a href="../loginusuario.php"
               class="bg-yellow-400 text-black px-4 py-2 rounded-lg font-bold hover:bg-yellow-300">

                Login

            </a>

        </nav>

    </div>

</header>


<!-- TÍTULO -->

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


<!-- FILTROS -->

<section class="max-w-7xl mx-auto px-6 py-8">

    <div class="flex flex-wrap gap-3">

        <a href="cardapio.php"
           class="px-5 py-2 rounded-lg bg-white shadow hover:bg-purple-100">

            Todos

        </a>

        <a href="cardapio.php?categoria=Copo"
           class="px-5 py-2 rounded-lg bg-white shadow hover:bg-purple-100">

            Copos

        </a>

        <a href="cardapio.php?categoria=Pote"
           class="px-5 py-2 rounded-lg bg-white shadow hover:bg-purple-100">

            Potes

        </a>

    </div>

</section>


<!-- PRODUTOS -->

<main class="max-w-7xl mx-auto px-6 pb-16">

    <?php if ($resultado->num_rows > 0): ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">


            <?php while ($produto = $resultado->fetch_assoc()): ?>


                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition">


                    <!-- IMAGEM -->

                    <div class="h-56 bg-gray-100 flex items-center justify-center">

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

                        <p class="text-sm text-gray-500 mb-1">

                            <?php echo htmlspecialchars($produto["TIPO_PROD"]); ?>

                        </p>


                        <h2 class="text-xl font-bold">

                            <?php echo htmlspecialchars($produto["NOME_PROD"]); ?>

                        </h2>


                        <p class="text-purple-700 text-xl font-bold mt-2">

                            R$

                            <?php echo number_format(
                                $produto["VALOR_PROD"],
                                2,
                                ",",
                                "."
                            ); ?>

                        </p>


                        <p class="text-sm text-gray-500 mt-2">

                            <?php echo $produto["ESTOQUE"]; ?> unidades disponíveis

                        </p>


                        <button
                            type="button"
                            class="btn-produto mt-4 w-full bg-purple-700 text-white py-3 rounded-lg font-semibold hover:bg-purple-800 transition"
                            data-id="<?php echo $produto["ID_PROD"]; ?>"
                            data-nome="<?php echo htmlspecialchars($produto["NOME_PROD"]); ?>"
                            data-preco="<?php echo $produto["VALOR_PROD"]; ?>">

                            Personalizar

                        </button>

                    </div>

                </div>


            <?php endwhile; ?>


        </div>


    <?php else: ?>


        <div class="bg-white rounded-2xl shadow p-12 text-center">

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


<!-- MODAL -->

<div
    id="modalProduto"
    class="hidden fixed inset-0 bg-black/50 flex items-center justify-center px-4 z-50">


    <div class="bg-white rounded-2xl w-full max-w-lg p-6">


        <div class="flex justify-between items-center mb-6">

            <h2
                id="modalNome"
                class="text-2xl font-bold">

                Produto

            </h2>


            <button
                id="fecharModal"
                class="text-gray-500 text-2xl hover:text-gray-800">

                &times;

            </button>

        </div>


        <p class="text-gray-600 mb-6">

            Personalização do produto.

        </p>


        <div class="border-t border-gray-200 pt-5">


            <label class="block font-semibold mb-2">

                Quantidade

            </label>


            <div class="flex items-center gap-3">


                <button
                    id="diminuirQuantidade"
                    class="w-10 h-10 rounded-lg bg-gray-200 text-xl">

                    -

                </button>


                <span
                    id="quantidadeProduto"
                    class="text-xl font-bold">

                    1

                </span>


                <button
                    id="aumentarQuantidade"
                    class="w-10 h-10 rounded-lg bg-purple-700 text-white text-xl">

                    +

                </button>


            </div>


        </div>


        <button
            id="adicionarCarrinho"
            class="mt-8 w-full bg-purple-700 text-white py-3 rounded-lg font-bold hover:bg-purple-800">

            Adicionar ao carrinho

        </button>


    </div>

</div>


<script src="../js/cardapio.js"></script>

</body>

</html>

<?php

$stmt->close();

$conexao->close();

?>
```
