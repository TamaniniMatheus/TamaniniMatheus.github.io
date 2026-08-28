// ==========================================================
// CARRINHO - REI DO AÇAÍ
// ==========================================================


// ==========================================================
// ELEMENTOS
// ==========================================================

const listaCarrinho =
    document.getElementById("listaCarrinho");

const carrinhoVazio =
    document.getElementById("carrinhoVazio");

const carrinhoConteudo =
    document.getElementById("carrinhoConteudo");

const subtotalCarrinho =
    document.getElementById("subtotalCarrinho");

const valorAdicionaisCarrinho =
    document.getElementById("valorAdicionaisCarrinho");

const totalCarrinho =
    document.getElementById("totalCarrinho");

const limparCarrinho =
    document.getElementById("limparCarrinho");

const finalizarPedido =
    document.getElementById("finalizarPedido");


// ==========================================================
// FORMATAR PREÇO
// ==========================================================

function formatarPreco(valor) {

    return Number(valor).toLocaleString(
        "pt-BR",
        {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }
    );

}


// ==========================================================
// OBTER CARRINHO
// ==========================================================

function obterCarrinho() {

    return JSON.parse(
        localStorage.getItem("carrinho")
    ) || [];

}


// ==========================================================
// SALVAR CARRINHO
// ==========================================================

function salvarCarrinho(carrinho) {

    localStorage.setItem(
        "carrinho",
        JSON.stringify(carrinho)
    );

}


// ==========================================================
// EXIBIR CARRINHO
// ==========================================================

function exibirCarrinho() {

    const carrinho =
        obterCarrinho();


    listaCarrinho.innerHTML = "";


    // ======================================================
    // CARRINHO VAZIO
    // ======================================================

    if (carrinho.length === 0) {

        carrinhoVazio.classList.remove(
            "hidden"
        );

        carrinhoConteudo.classList.add(
            "hidden"
        );

        return;

    }


    carrinhoVazio.classList.add(
        "hidden"
    );

    carrinhoConteudo.classList.remove(
        "hidden"
    );


    let subtotalProdutos = 0;

    let totalAdicionais = 0;


    // ======================================================
    // PRODUTOS
    // ======================================================

    carrinho.forEach(
        function (item, index) {


            const valorProduto =
                Number(
                    item.preco
                );


            const quantidade =
                Number(
                    item.quantidade
                );


            const subtotalProduto =
                valorProduto *
                quantidade;


            let valorAdicionaisItem = 0;


            // =================================================
            // ADICIONAIS
            // =================================================

            if (
                item.adicionais &&
                item.adicionais.length > 0
            ) {

                item.adicionais.forEach(
                    function (adicional) {

                        valorAdicionaisItem +=
                            Number(
                                adicional.preco
                            );

                    }
                );

            }


            valorAdicionaisItem *=
                quantidade;


            // =================================================
            // TOTAIS
            // =================================================

            subtotalProdutos +=
                subtotalProduto;


            totalAdicionais +=
                valorAdicionaisItem;


            const subtotalItem =
                subtotalProduto +
                valorAdicionaisItem;


            // =================================================
            // ADICIONAIS
            // =================================================

            let htmlAdicionais = "";


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

                            ${item.adicionais.map(

                                function (adicional) {


                                    let textoPreco = "";


                                    if (
                                        Number(
                                            adicional.preco
                                        ) > 0
                                    ) {

                                        textoPreco =
                                            " + R$ " +
                                            formatarPreco(
                                                adicional.preco
                                            );

                                    } else {

                                        textoPreco =
                                            " (grátis)";

                                    }


                                    return `

                                        <li>

                                            • ${adicional.nome}

                                            ${textoPreco}

                                        </li>

                                    `;

                                }

                            ).join("")}

                        </ul>

                    </div>

                `;

            }


            // =================================================
            // IMAGEM DO PRODUTO
            // =================================================

            let htmlImagem = "";


            if (
                item.imagem &&
                item.imagem.trim() !== ""
            ) {

                htmlImagem = `

                    <img
                        src="../${item.imagem}"
                        alt="${item.nome}"
                        class="w-full h-full object-contain">

                `;

            } else {

                htmlImagem = `

                    <span class="text-gray-400 text-sm">

                        Sem imagem

                    </span>

                `;

            }


            // =================================================
            // CARD
            // =================================================

            const card =
                document.createElement(
                    "div"
                );


            card.className =
                "bg-white rounded-2xl shadow-sm border border-gray-100 p-5";


            card.innerHTML = `

                <div class="flex flex-col sm:flex-row gap-5">


                    <!-- IMAGEM -->

                    <div
                        class="w-full sm:w-32 h-32 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden">

                        ${htmlImagem}

                    </div>


                    <!-- INFORMAÇÕES -->

                    <div class="flex-1">


                        <div
                            class="flex justify-between gap-4">


                            <div>

                                <h3
                                    class="text-xl font-bold">

                                    ${item.nome}

                                </h3>


                                <p
                                    class="text-gray-500 text-sm mt-1">

                                    R$

                                    ${formatarPreco(
                                        item.preco
                                    )}

                                </p>

                            </div>


                            <button
                                type="button"
                                class="remover-item text-red-600 text-sm font-semibold hover:text-red-800"

                                data-index="${index}">

                                Remover

                            </button>


                        </div>


                        ${htmlAdicionais}


                        <!-- QUANTIDADE -->

                        <div
                            class="flex flex-wrap justify-between items-center gap-4 mt-5">


                            <div
                                class="flex items-center gap-3">


                                <button
                                    type="button"
                                    class="diminuir-item w-9 h-9 rounded-lg bg-gray-200 hover:bg-gray-300 font-bold"

                                    data-index="${index}">

                                    -

                                </button>


                                <span
                                    class="font-bold">

                                    ${quantidade}

                                </span>


                                <button
                                    type="button"
                                    class="aumentar-item w-9 h-9 rounded-lg bg-purple-700 text-white hover:bg-purple-800 font-bold"

                                    data-index="${index}">

                                    +

                                </button>


                            </div>


                            <!-- SUBTOTAL -->

                            <div
                                class="text-right">


                                <p
                                    class="text-sm text-gray-500">

                                    Subtotal

                                </p>


                                <p
                                    class="text-lg font-bold text-purple-700">

                                    R$

                                    ${formatarPreco(
                                        subtotalItem
                                    )}

                                </p>


                            </div>


                        </div>


                    </div>


                </div>

            `;


            listaCarrinho.appendChild(
                card
            );

        }
    );


    // ======================================================
    // RESUMO
    // ======================================================

    subtotalCarrinho.textContent =
        "R$ " +
        formatarPreco(
            subtotalProdutos
        );


    valorAdicionaisCarrinho.textContent =
        "R$ " +
        formatarPreco(
            totalAdicionais
        );


    totalCarrinho.textContent =
        "R$ " +
        formatarPreco(
            subtotalProdutos +
            totalAdicionais
        );


    configurarBotoes();

}


// ==========================================================
// CONFIGURAR BOTÕES
// ==========================================================

function configurarBotoes() {


    // ======================================================
    // REMOVER
    // ======================================================

    const botoesRemover =
        document.querySelectorAll(
            ".remover-item"
        );


    botoesRemover.forEach(
        function (botao) {

            botao.addEventListener(
                "click",
                function () {

                    const index =
                        Number(
                            botao.dataset.index
                        );


                    const carrinho =
                        obterCarrinho();


                    carrinho.splice(
                        index,
                        1
                    );


                    salvarCarrinho(
                        carrinho
                    );


                    exibirCarrinho();

                }
            );

        }
    );


    // ======================================================
    // AUMENTAR
    // ======================================================

    const botoesAumentar =
        document.querySelectorAll(
            ".aumentar-item"
        );


    botoesAumentar.forEach(
        function (botao) {

            botao.addEventListener(
                "click",
                function () {

                    const index =
                        Number(
                            botao.dataset.index
                        );


                    const carrinho =
                        obterCarrinho();


                    carrinho[index].quantidade++;


                    salvarCarrinho(
                        carrinho
                    );


                    exibirCarrinho();

                }
            );

        }
    );


    // ======================================================
    // DIMINUIR
    // ======================================================

    const botoesDiminuir =
        document.querySelectorAll(
            ".diminuir-item"
        );


    botoesDiminuir.forEach(
        function (botao) {

            botao.addEventListener(
                "click",
                function () {

                    const index =
                        Number(
                            botao.dataset.index
                        );


                    const carrinho =
                        obterCarrinho();


                    if (
                        carrinho[index].quantidade >
                        1
                    ) {

                        carrinho[index].quantidade--;

                    } else {

                        carrinho.splice(
                            index,
                            1
                        );

                    }


                    salvarCarrinho(
                        carrinho
                    );


                    exibirCarrinho();

                }
            );

        }
    );

}


// ==========================================================
// LIMPAR CARRINHO
// ==========================================================

if (limparCarrinho) {

    limparCarrinho.addEventListener(
        "click",
        function () {

            const confirmar =
                confirm(
                    "Deseja realmente limpar o carrinho?"
                );


            if (!confirmar) {

                return;

            }


            localStorage.removeItem(
                "carrinho"
            );


            exibirCarrinho();

        }
    );

}


// ==========================================================
// FINALIZAR PEDIDO
// ==========================================================

if (finalizarPedido) {

    finalizarPedido.addEventListener(
        "click",
        function () {

            const carrinho =
                obterCarrinho();


            if (carrinho.length === 0) {

                alert(
                    "Seu carrinho está vazio."
                );

                return;

            }


            window.location.href =
                "confirmar_pedido.php";

        }
    );

}


// ==========================================================
// INICIALIZAÇÃO
// ==========================================================

exibirCarrinho();