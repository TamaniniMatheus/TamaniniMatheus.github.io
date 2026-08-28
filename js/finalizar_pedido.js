document.addEventListener("DOMContentLoaded", function () {

    const carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];

    const resumoProdutos = document.getElementById("resumoProdutos");
    const subtotalProdutos = document.getElementById("subtotalProdutos");
    const subtotalAdicionais = document.getElementById("subtotalAdicionais");
    const totalPedido = document.getElementById("totalPedido");
    const formFinalizarPedido = document.getElementById("formFinalizarPedido");

    let valorProdutos = 0;
    let valorAdicionais = 0;

    resumoProdutos.innerHTML = "";

    /*
    |--------------------------------------------------------------------------
    | VERIFICAR CARRINHO
    |--------------------------------------------------------------------------
    */

    if (carrinho.length === 0) {

        resumoProdutos.innerHTML = `
            <p class="text-gray-500">
                Seu carrinho está vazio.
            </p>
        `;

        if (formFinalizarPedido) {
            formFinalizarPedido.style.display = "none";
        }

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | MOSTRAR PRODUTOS
    |--------------------------------------------------------------------------
    */

    carrinho.forEach(function (item) {

        const quantidade = Number(item.quantidade) || 1;
        const valorProduto = Number(item.valor) || 0;

        const subtotalProduto = valorProduto * quantidade;

        valorProdutos += subtotalProduto;


        let adicionaisHTML = "";


        /*
        |--------------------------------------------------------------------------
        | ADICIONAIS
        |--------------------------------------------------------------------------
        */

        if (
            item.adicionais &&
            Array.isArray(item.adicionais) &&
            item.adicionais.length > 0
        ) {

            adicionaisHTML = `
                <div class="mt-2 text-sm text-gray-500">

                    ${item.adicionais.map(function (adicional) {

                        const valorAdicional =
                            Number(adicional.valor) || 0;

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


        /*
        |--------------------------------------------------------------------------
        | PRODUTO NO RESUMO
        |--------------------------------------------------------------------------
        */

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


    /*
    |--------------------------------------------------------------------------
    | TOTAL
    |--------------------------------------------------------------------------
    */

    const total = valorProdutos + valorAdicionais;


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


    /*
    |--------------------------------------------------------------------------
    | ENVIAR CARRINHO PARA O PHP
    |--------------------------------------------------------------------------
    */

    if (formFinalizarPedido) {

        formFinalizarPedido.addEventListener(
            "submit",
            function () {

                /*
                | O localStorage não é enviado automaticamente
                | pelo formulário.
                |
                | Por isso criamos um input hidden contendo
                | o carrinho em formato JSON.
                */

                let inputCarrinho =
                    document.getElementById("inputCarrinho");


                /*
                | Se ainda não existir, cria o input.
                */

                if (!inputCarrinho) {

                    inputCarrinho =
                        document.createElement("input");

                    inputCarrinho.type = "hidden";
                    inputCarrinho.name = "carrinho";
                    inputCarrinho.id = "inputCarrinho";

                    formFinalizarPedido.appendChild(
                        inputCarrinho
                    );
                }


                /*
                | Coloca o carrinho dentro do input.
                */

                inputCarrinho.value =
                    JSON.stringify(carrinho);

            }
        );

    }

});