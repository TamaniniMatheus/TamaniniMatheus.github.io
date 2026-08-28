document.addEventListener("DOMContentLoaded", function () {

    // ==========================================================
    // CARRINHO
    // ==========================================================

    const carrinho =
        JSON.parse(localStorage.getItem("carrinho")) || [];


    // ==========================================================
    // ELEMENTOS
    // ==========================================================

    const resumoProdutos =
        document.getElementById("resumoProdutos");

    const subtotalProdutos =
        document.getElementById("subtotalProdutos");

    const subtotalAdicionais =
        document.getElementById("subtotalAdicionais");

    const totalPedido =
        document.getElementById("totalPedido");

    const formFinalizarPedido =
        document.getElementById("formFinalizarPedido");


    // ==========================================================
    // VERIFICAR CARRINHO
    // ==========================================================

    if (carrinho.length === 0) {

        resumoProdutos.innerHTML = `
            <p class="text-gray-500">
                Seu carrinho está vazio.
            </p>
        `;

        return;
    }


    // ==========================================================
    // TOTAIS
    // ==========================================================

    let valorProdutos = 0;
    let valorAdicionais = 0;


    // ==========================================================
    // EXIBIR PRODUTOS
    // ==========================================================

    resumoProdutos.innerHTML = "";


    carrinho.forEach(function (item) {

        const quantidade =
            Number(item.quantidade) || 1;

        const valorProduto =
            Number(item.preco) || 0;


        const subtotalProduto =
            valorProduto * quantidade;


        valorProdutos += subtotalProduto;


        // ======================================================
        // ADICIONAIS
        // ======================================================

        let adicionaisHTML = "";


        if (
            item.adicionais &&
            item.adicionais.length > 0
        ) {

            adicionaisHTML = `
                <div class="mt-2 text-sm text-gray-500">

                    ${item.adicionais.map(function (adicional) {

                        const valorAdicional =
                            Number(adicional.preco) || 0;


                        valorAdicionais +=
                            valorAdicional * quantidade;


                        return `
                            <p>
                                + ${adicional.nome}

                                ${
                                    valorAdicional > 0
                                        ? ` — R$ ${valorAdicional
                                            .toFixed(2)
                                            .replace(".", ",")}`
                                        : " (grátis)"
                                }

                            </p>
                        `;

                    }).join("")}

                </div>
            `;
        }


        // ======================================================
        // CARD DO PRODUTO
        // ======================================================

        resumoProdutos.innerHTML += `

            <div class="border-b border-gray-100 pb-4">

                <div class="flex justify-between gap-4">

                    <div>

                        <p class="font-semibold">

                            ${quantidade}x ${item.nome}

                        </p>

                        ${adicionaisHTML}

                    </div>


                    <p class="font-semibold whitespace-nowrap">

                        R$ ${subtotalProduto
                            .toFixed(2)
                            .replace(".", ",")}

                    </p>

                </div>

            </div>

        `;

    });


    // ==========================================================
    // TOTAL
    // ==========================================================

    const total =
        valorProdutos +
        valorAdicionais;


    subtotalProdutos.textContent =
        "R$ " +
        valorProdutos
            .toFixed(2)
            .replace(".", ",");


    subtotalAdicionais.textContent =
        "R$ " +
        valorAdicionais
            .toFixed(2)
            .replace(".", ",");


    totalPedido.textContent =
        "R$ " +
        total
            .toFixed(2)
            .replace(".", ",");


    // ==========================================================
    // ENVIAR PEDIDO
    // ==========================================================

    if (formFinalizarPedido) {

        formFinalizarPedido.addEventListener(
            "submit",
            function (event) {

                // Impede o envio original
                event.preventDefault();


                // ==================================================
                // VERIFICAR CARRINHO
                // ==================================================

                if (carrinho.length === 0) {

                    alert(
                        "Seu carrinho está vazio."
                    );

                    return;
                }


                // ==================================================
                // VERIFICAR PAGAMENTO
                // ==================================================

                const pagamentoSelecionado =
                    document.querySelector(
                        'input[name="metodo_pag"]:checked'
                    );


                if (!pagamentoSelecionado) {

                    alert(
                        "Selecione uma forma de pagamento."
                    );

                    return;
                }


                // ==================================================
                // ADICIONAR CARRINHO AO FORMULÁRIO
                // ==================================================

                let campoCarrinho =
                    document.getElementById(
                        "campoCarrinho"
                    );


                if (!campoCarrinho) {

                    campoCarrinho =
                        document.createElement("input");

                    campoCarrinho.type = "hidden";

                    campoCarrinho.name = "carrinho";

                    campoCarrinho.id = "campoCarrinho";

                    formFinalizarPedido.appendChild(
                        campoCarrinho
                    );

                }


                campoCarrinho.value =
                    JSON.stringify(carrinho);


                // ==================================================
                // ENVIAR PARA O PHP
                // ==================================================

                formFinalizarPedido.submit();

            }
        );

    }

});