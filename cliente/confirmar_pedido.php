<?php

session_start();

/*
|--------------------------------------------------------------------------
| VERIFICAR LOGIN
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["ID_CLI"])) {
    header("Location: ../loginusuario.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| OBTER ID DO CLIENTE
|--------------------------------------------------------------------------
*/

$id_cliente = (int) $_SESSION["ID_CLI"];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Confirmar Pedido | Rei do Açaí</title>

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

            Confirmar pedido

        </h1>


        <p class="mt-2 text-purple-100">

            Confira os dados do seu pedido antes de finalizar.

        </p>

    </div>

</section>


<!-- =========================================================
     CONTEÚDO
========================================================= -->

<main class="max-w-7xl mx-auto px-6 py-10">


    <div
        id="mensagemErro"
        class="hidden bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-6">
    </div>


    <div
        id="conteudoConfirmacao"
        class="grid grid-cols-1 lg:grid-cols-3 gap-8">


        <!-- =================================================
             PRODUTOS
        ================================================== -->

        <section class="lg:col-span-2">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

                <h2 class="text-2xl font-bold mb-6">

                    Resumo dos produtos

                </h2>


                <div
                    id="listaConfirmacao"
                    class="space-y-5">
                </div>

            </div>


            <!-- =================================================
                 ENDEREÇO
            ================================================== -->

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mt-6">

                <h2 class="text-2xl font-bold mb-6">

                    Endereço de entrega

                </h2>


                <p class="text-sm text-gray-500 mb-5">

                    Informe o endereço onde deseja receber seu pedido.

                </p>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


                    <div class="md:col-span-2">

                        <label class="block text-sm font-semibold mb-2">

                            Rua

                        </label>

                        <input
                            type="text"
                            id="rua"
                            name="rua"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-600"
                            placeholder="Digite sua rua">

                    </div>


                    <div>

                        <label class="block text-sm font-semibold mb-2">

                            Número

                        </label>

                        <input
                            type="text"
                            id="numero"
                            name="numero"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-600"
                            placeholder="Número">

                    </div>


                    <div>

                        <label class="block text-sm font-semibold mb-2">

                            Bairro

                        </label>

                        <input
                            type="text"
                            id="bairro"
                            name="bairro"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-600"
                            placeholder="Bairro">

                    </div>


                    <div>

                        <label class="block text-sm font-semibold mb-2">

                            Cidade

                        </label>

                        <input
                            type="text"
                            id="cidade"
                            name="cidade"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-600"
                            placeholder="Cidade">

                    </div>


                    <div>

                        <label class="block text-sm font-semibold mb-2">

                            Estado

                        </label>

                        <input
                            type="text"
                            id="estado"
                            name="estado"
                            maxlength="2"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 uppercase focus:outline-none focus:ring-2 focus:ring-purple-600"
                            placeholder="SP">

                    </div>


                    <div>

                        <label class="block text-sm font-semibold mb-2">

                            CEP

                        </label>

                        <input
                            type="text"
                            id="cep"
                            name="cep"
                            maxlength="8"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-600"
                            placeholder="00000000">

                    </div>


                    <div>

                        <label class="block text-sm font-semibold mb-2">

                            Complemento

                        </label>

                        <input
                            type="text"
                            id="complemento"
                            name="complemento"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-600"
                            placeholder="Casa, apartamento etc.">

                    </div>

                </div>

            </div>

        </section>


        <!-- =================================================
             RESUMO FINAL
        ================================================== -->

        <aside>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">


                <h2 class="text-2xl font-bold mb-6">

                    Resumo do pedido

                </h2>


                <div class="flex justify-between text-gray-600 mb-3">

                    <span>

                        Produtos

                    </span>


                    <span id="subtotalProdutos">

                        R$ 0,00

                    </span>

                </div>


                <div class="flex justify-between text-gray-600 mb-4">

                    <span>

                        Adicionais

                    </span>


                    <span id="subtotalAdicionais">

                        R$ 0,00

                    </span>

                </div>


                <div class="border-t border-gray-200 pt-4">


                    <div class="flex justify-between items-center">

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


                <!-- =================================================
                     PAGAMENTO
                ================================================== -->

                <div class="border-t border-gray-200 mt-6 pt-6">

                    <h3 class="font-bold text-lg mb-4">

                        Forma de pagamento

                    </h3>


                    <div class="space-y-3">


                        <label
                            class="flex items-center gap-3 border border-gray-200 rounded-lg p-3 cursor-pointer hover:border-purple-500">

                            <input
                                type="radio"
                                name="metodo_pag"
                                value="PIX"
                                class="w-4 h-4">

                            <span>

                                PIX

                            </span>

                        </label>


                        <label
                            class="flex items-center gap-3 border border-gray-200 rounded-lg p-3 cursor-pointer hover:border-purple-500">

                            <input
                                type="radio"
                                name="metodo_pag"
                                value="Dinheiro"
                                class="w-4 h-4">

                            <span>

                                Dinheiro

                            </span>

                        </label>


                        <label
                            class="flex items-center gap-3 border border-gray-200 rounded-lg p-3 cursor-pointer hover:border-purple-500">

                            <input
                                type="radio"
                                name="metodo_pag"
                                value="Cartão"
                                class="w-4 h-4">

                            <span>

                                Cartão

                            </span>

                        </label>


                    </div>

                </div>


                <!-- =================================================
                     BOTÃO
                ================================================== -->

                <button
                    id="confirmarPedido"
                    type="button"
                    class="mt-6 w-full bg-purple-700 text-white py-4 rounded-lg font-bold hover:bg-purple-800 transition">

                    Confirmar pedido

                </button>


                <a
                    href="carrinho.php"
                    class="block text-center mt-4 text-purple-700 font-semibold hover:text-purple-900">

                    ← Voltar ao carrinho

                </a>

            </div>

        </aside>

    </div>


    <!-- =========================================================
         CARRINHO VAZIO
    ========================================================= -->

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

</main>


<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script>

const listaConfirmacao =
    document.getElementById("listaConfirmacao");

const conteudoConfirmacao =
    document.getElementById("conteudoConfirmacao");

const carrinhoVazio =
    document.getElementById("carrinhoVazio");

const subtotalProdutos =
    document.getElementById("subtotalProdutos");

const subtotalAdicionais =
    document.getElementById("subtotalAdicionais");

const totalPedido =
    document.getElementById("totalPedido");

const mensagemErro =
    document.getElementById("mensagemErro");

const confirmarPedido =
    document.getElementById("confirmarPedido");


/*
|--------------------------------------------------------------------------
| FORMATAR PREÇO
|--------------------------------------------------------------------------
*/

function formatarPreco(valor) {

    return Number(valor).toLocaleString("pt-BR", {

        minimumFractionDigits: 2,

        maximumFractionDigits: 2

    });

}


/*
|--------------------------------------------------------------------------
| OBTER CARRINHO
|--------------------------------------------------------------------------
*/

function obterCarrinho() {

    return JSON.parse(
        localStorage.getItem("carrinho")
    ) || [];

}


/*
|--------------------------------------------------------------------------
| EXIBIR CARRINHO
|--------------------------------------------------------------------------
*/

function exibirConfirmacao() {

    const carrinho =
        obterCarrinho();


    listaConfirmacao.innerHTML = "";


    if (carrinho.length === 0) {

        conteudoConfirmacao.classList.add("hidden");

        carrinhoVazio.classList.remove("hidden");

        return;

    }


    conteudoConfirmacao.classList.remove("hidden");

    carrinhoVazio.classList.add("hidden");


    let totalProdutos = 0;

    let totalAdicionais = 0;


    carrinho.forEach(function(item) {


        const quantidade =
            Number(item.quantidade);


        const precoProduto =
            Number(item.preco);


        const subtotalProduto =
            precoProduto * quantidade;


        let valorAdicionais =
            0;


        let htmlAdicionais =
            "";


        if (
            item.adicionais &&
            item.adicionais.length > 0
        ) {

            htmlAdicionais = `
                <div class="mt-3">

                    <p class="text-sm font-semibold text-gray-700">

                        Adicionais:

                    </p>

                    <ul class="text-sm text-gray-500 mt-1 space-y-1">

                        ${item.adicionais.map(function(adicional) {

                            const preco =
                                Number(adicional.preco);

                            valorAdicionais += preco;

                            return `
                                <li>
                                    • ${adicional.nome}
                                    ${
                                        preco > 0
                                        ? " + R$ " + formatarPreco(preco)
                                        : " (grátis)"
                                    }
                                </li>
                            `;

                        }).join("")}

                    </ul>

                </div>
            `;

        }


        valorAdicionais *= quantidade;


        const subtotalItem =
            subtotalProduto +
            valorAdicionais;


        totalProdutos +=
            subtotalProduto;


        totalAdicionais +=
            valorAdicionais;


        const card =
            document.createElement("div");


        card.className =
            "border-b border-gray-200 pb-5 last:border-b-0";


        card.innerHTML = `

            <div class="flex justify-between gap-4">

                <div>

                    <h3 class="font-bold text-lg">

                        ${item.nome}

                    </h3>

                    <p class="text-sm text-gray-500 mt-1">

                        ${quantidade} unidade(s)

                    </p>

                    ${htmlAdicionais}

                </div>


                <div class="text-right">

                    <p class="text-sm text-gray-500">

                        Subtotal

                    </p>

                    <p class="font-bold text-purple-700">

                        R$ ${formatarPreco(subtotalItem)}

                    </p>

                </div>

            </div>

        `;


        listaConfirmacao.appendChild(card);

    });


    subtotalProdutos.textContent =
        "R$ " +
        formatarPreco(totalProdutos);


    subtotalAdicionais.textContent =
        "R$ " +
        formatarPreco(totalAdicionais);


    totalPedido.textContent =
        "R$ " +
        formatarPreco(
            totalProdutos +
            totalAdicionais
        );

}


/*
|--------------------------------------------------------------------------
| MOSTRAR ERRO
|--------------------------------------------------------------------------
*/

function mostrarErro(mensagem) {

    mensagemErro.textContent =
        mensagem;

    mensagemErro.classList.remove("hidden");

    mensagemErro.scrollIntoView({
        behavior: "smooth"
    });

}


/*
|--------------------------------------------------------------------------
| CONFIRMAR PEDIDO
|--------------------------------------------------------------------------
*/

confirmarPedido.addEventListener(
    "click",
    function() {


        const carrinho =
            obterCarrinho();


        if (carrinho.length === 0) {

            mostrarErro(
                "Seu carrinho está vazio."
            );

            return;

        }


        const rua =
            document.getElementById("rua").value.trim();


        const numero =
            document.getElementById("numero").value.trim();


        const bairro =
            document.getElementById("bairro").value.trim();


        const cidade =
            document.getElementById("cidade").value.trim();


        const estado =
            document.getElementById("estado").value.trim();


        const cep =
            document.getElementById("cep").value.trim();


        const complemento =
            document.getElementById("complemento").value.trim();


        const metodoPagamento =
            document.querySelector(
                'input[name="metodo_pag"]:checked'
            );


        if (
            rua === "" ||
            numero === "" ||
            bairro === "" ||
            cidade === "" ||
            estado === "" ||
            cep === ""
        ) {

            mostrarErro(
                "Preencha todos os campos obrigatórios do endereço."
            );

            return;

        }


        if (!metodoPagamento) {

            mostrarErro(
                "Selecione uma forma de pagamento."
            );

            return;

        }


        /*
        ----------------------------------------------------------
        PREPARAR DADOS PARA A PRÓXIMA ETAPA
        ----------------------------------------------------------
        */

        const dadosPedido = {

            cliente: <?php echo $id_cliente; ?>,

            carrinho: carrinho,

            endereco: {

                rua: rua,

                numero: numero,

                bairro: bairro,

                cidade: cidade,

                estado: estado,

                cep: cep,

                complemento: complemento

            },

            metodo_pagamento:
                metodoPagamento.value

        };


        /*
        ----------------------------------------------------------
        SALVAR TEMPORARIAMENTE
        ----------------------------------------------------------
        */

        localStorage.setItem(
            "dadosPedido",
            JSON.stringify(dadosPedido)
        );


        /*
        ----------------------------------------------------------
        PRÓXIMA ETAPA
        ----------------------------------------------------------
        */

        window.location.href =
            "../processa/finalizar_pedido.php";

    }
);


/*
|--------------------------------------------------------------------------
| INICIAR
|--------------------------------------------------------------------------
*/

exibirConfirmacao();

</script>


</body>

</html>