// ==========================================================
// CARDÁPIO - REI DO AÇAÍ
// ==========================================================

let produtoSelecionado = null;

let quantidade = 1;


// ==========================================================
// ELEMENTOS DO MODAL
// ==========================================================

const modalProduto =
    document.getElementById("modalProduto");

const fecharModal =
    document.getElementById("fecharModal");

const modalNome =
    document.getElementById("modalNome");

const modalPreco =
    document.getElementById("modalPreco");

const quantidadeProduto =
    document.getElementById("quantidadeProduto");

const aumentarQuantidade =
    document.getElementById("aumentarQuantidade");

const diminuirQuantidade =
    document.getElementById("diminuirQuantidade");

const limiteGratis =
    document.getElementById("limiteGratis");

const limiteAdicionais =
    document.getElementById("limiteAdicionais");

const contadorAdicionais =
    document.getElementById("contadorAdicionais");

const resumoProduto =
    document.getElementById("resumoProduto");

const resumoAdicionais =
    document.getElementById("resumoAdicionais");

const totalProduto =
    document.getElementById("totalProduto");

const adicionarCarrinho =
    document.getElementById("adicionarCarrinho");


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
// LIMITE DE ADICIONAIS GRÁTIS
// ==========================================================

function obterLimiteAdicionais(nomeProduto) {

    const nome =
        nomeProduto.toLowerCase();


    if (nome.includes("400ml")) {

        return 3;

    }


    if (nome.includes("500ml")) {

        return 4;

    }


    if (nome.includes("700ml")) {

        return 5;

    }


    if (
        nome.includes("1litro") ||
        nome.includes("1 litro")
    ) {

        return 5;

    }


    return 0;

}


// ==========================================================
// VERIFICAR NUTELLA
// ==========================================================

function ehNutella(nome) {

    return nome
        .toLowerCase()
        .includes("nutella original");

}


// ==========================================================
// PREÇO DA NUTELLA
// ==========================================================

function obterPrecoNutella() {

    if (!produtoSelecionado) {

        return 0;

    }


    const nome =
        produtoSelecionado.nome.toLowerCase();


    if (
        nome.includes("1litro") ||
        nome.includes("1 litro")
    ) {

        return 15;

    }


    return 8;

}


// ==========================================================
// OBTER ADICIONAIS SELECIONADOS
// ==========================================================

function obterAdicionaisSelecionados() {

    const checkboxes =
        document.querySelectorAll(
            ".adicional-checkbox:checked"
        );


    return Array.from(
        checkboxes
    );

}


// ==========================================================
// CALCULAR ADICIONAIS
// ==========================================================

function calcularAdicionais() {

    if (!produtoSelecionado) {

        return {
            valor: 0,
            normais: 0,
            gratis: 0,
            excedentes: 0
        };

    }


    const limite =
        obterLimiteAdicionais(
            produtoSelecionado.nome
        );


    const selecionados =
        obterAdicionaisSelecionados();


    let adicionaisNormais = 0;

    let adicionaisGratis = 0;

    let adicionaisExcedentes = 0;

    let valor = 0;


    // Contar adicionais normais

    selecionados.forEach(
        function (checkbox) {

            const nome =
                checkbox.dataset.nome;


            if (!ehNutella(nome)) {

                adicionaisNormais++;

            }

        }
    );


    // Adicionais grátis

    adicionaisGratis =
        Math.min(
            adicionaisNormais,
            limite
        );


    // Adicionais excedentes

    adicionaisExcedentes =
        Math.max(
            0,
            adicionaisNormais - limite
        );


    // R$ 5 por adicional excedente

    valor +=
        adicionaisExcedentes * 5;


    // Nutella

    selecionados.forEach(
        function (checkbox) {

            const nome =
                checkbox.dataset.nome;


            if (ehNutella(nome)) {

                valor +=
                    obterPrecoNutella();

            }

        }
    );


    return {

        valor: valor,

        normais:
            adicionaisNormais,

        gratis:
            adicionaisGratis,

        excedentes:
            adicionaisExcedentes

    };

}


// ==========================================================
// ATUALIZAR CONTADOR
// ==========================================================

function atualizarContador() {

    if (!produtoSelecionado) {

        return;

    }


    const limite =
        obterLimiteAdicionais(
            produtoSelecionado.nome
        );


    const selecionados =
        obterAdicionaisSelecionados();


    contadorAdicionais.textContent =
        selecionados.length;


    limiteAdicionais.textContent =
        limite;


    limiteGratis.textContent =
        limite;

}


// ==========================================================
// ATUALIZAR TOTAL
// ==========================================================

function atualizarTotal() {

    if (!produtoSelecionado) {

        return;

    }


    const resultado =
        calcularAdicionais();


    const valorProduto =
        Number(
            produtoSelecionado.preco
        );


    const subtotalProduto =
        valorProduto * quantidade;


    const subtotalAdicionais =
        resultado.valor * quantidade;


    const total =
        subtotalProduto +
        subtotalAdicionais;


    resumoProduto.textContent =
        "R$ " +
        formatarPreco(
            subtotalProduto
        );


    resumoAdicionais.textContent =
        "R$ " +
        formatarPreco(
            subtotalAdicionais
        );


    totalProduto.textContent =
        "R$ " +
        formatarPreco(
            total
        );


    atualizarContador();

}


// ==========================================================
// LIMPAR ADICIONAIS
// ==========================================================

function limparAdicionais() {

    const checkboxes =
        document.querySelectorAll(
            ".adicional-checkbox"
        );


    checkboxes.forEach(
        function (checkbox) {

            checkbox.checked = false;

        }
    );

}


// ==========================================================
// ABRIR MODAL
// ==========================================================

function abrirModal(botao) {

    produtoSelecionado = {

        id:
            botao.dataset.id,

        nome:
            botao.dataset.nome,

        preco:
            Number(
                botao.dataset.preco
            ),

        imagem:
            botao.dataset.imagem,

        estoque:
            Number(
                botao.dataset.estoque
            )

    };


    quantidade = 1;


    limparAdicionais();


    modalNome.textContent =
        produtoSelecionado.nome;


    modalPreco.textContent =
        "R$ " +
        formatarPreco(
            produtoSelecionado.preco
        );


    quantidadeProduto.textContent =
        quantidade;


    modalProduto.classList.remove(
        "hidden"
    );


    atualizarTotal();

}


// ==========================================================
// BOTÕES DOS PRODUTOS
// ==========================================================

const botoesProduto =
    document.querySelectorAll(
        ".btn-produto"
    );


botoesProduto.forEach(
    function (botao) {

        botao.addEventListener(
            "click",
            function () {

                abrirModal(
                    botao
                );

            }
        );

    }
);


// ==========================================================
// FECHAR MODAL
// ==========================================================

if (fecharModal) {

    fecharModal.addEventListener(
        "click",
        function () {

            modalProduto.classList.add(
                "hidden"
            );

        }
    );

}


// ==========================================================
// FECHAR CLICANDO FORA
// ==========================================================

if (modalProduto) {

    modalProduto.addEventListener(
        "click",
        function (evento) {

            if (
                evento.target ===
                modalProduto
            ) {

                modalProduto.classList.add(
                    "hidden"
                );

            }

        }
    );

}


// ==========================================================
// AUMENTAR QUANTIDADE
// ==========================================================

if (aumentarQuantidade) {

    aumentarQuantidade.addEventListener(
        "click",
        function () {

            if (!produtoSelecionado) {

                return;

            }


            if (
                quantidade <
                produtoSelecionado.estoque
            ) {

                quantidade++;


                quantidadeProduto.textContent =
                    quantidade;


                atualizarTotal();

            }

        }
    );

}


// ==========================================================
// DIMINUIR QUANTIDADE
// ==========================================================

if (diminuirQuantidade) {

    diminuirQuantidade.addEventListener(
        "click",
        function () {

            if (quantidade > 1) {

                quantidade--;


                quantidadeProduto.textContent =
                    quantidade;


                atualizarTotal();

            }

        }
    );

}


// ==========================================================
// ADICIONAIS
// ==========================================================

const checkboxes =
    document.querySelectorAll(
        ".adicional-checkbox"
    );


checkboxes.forEach(
    function (checkbox) {

        checkbox.addEventListener(
            "change",
            function () {

                atualizarTotal();

            }
        );

    }
);


// ==========================================================
// ADICIONAR AO CARRINHO
// ==========================================================

if (adicionarCarrinho) {

    adicionarCarrinho.addEventListener(
        "click",
        function () {

            if (!produtoSelecionado) {

                return;

            }


            const selecionados =
                obterAdicionaisSelecionados();


            const resultado =
                calcularAdicionais();


            const adicionais = [];


            // Montar adicionais

            selecionados.forEach(
                function (checkbox) {

                    const nome =
                        checkbox.dataset.nome;


                    let preco = 0;


                    // Nutella

                    if (ehNutella(nome)) {

                        preco =
                            obterPrecoNutella();

                    }


                    // Adicional normal

                    else {

                        let quantidadeAnterior = 0;


                        for (
                            let i = 0;
                            i < selecionados.indexOf(checkbox);
                            i++
                        ) {

                            if (
                                !ehNutella(
                                    selecionados[i].dataset.nome
                                )
                            ) {

                                quantidadeAnterior++;

                            }

                        }


                        if (
                            quantidadeAnterior >=
                            obterLimiteAdicionais(
                                produtoSelecionado.nome
                            )
                        ) {

                            preco = 5;

                        }

                    }


                    adicionais.push({

                        id:
                            Number(
                                checkbox.dataset.id
                            ),

                        nome:
                            nome,

                        preco:
                            preco

                    });

                }
            );


            // Subtotal

            const subtotal =
                (
                    produtoSelecionado.preco +
                    resultado.valor
                ) * quantidade;


            // Item do carrinho

            const itemCarrinho = {

                id:
                    produtoSelecionado.id,

                nome:
                    produtoSelecionado.nome,

                preco:
                    produtoSelecionado.preco,

                imagem:
                    produtoSelecionado.imagem,

                quantidade:
                    quantidade,

                adicionais:
                    adicionais,

                subtotal:
                    subtotal

            };


            // Recuperar carrinho

            let carrinho =
                JSON.parse(
                    localStorage.getItem(
                        "carrinho"
                    )
                ) || [];


            // Adicionar

            carrinho.push(
                itemCarrinho
            );


            // Salvar

            localStorage.setItem(
                "carrinho",
                JSON.stringify(
                    carrinho
                )
            );


            // Fechar modal

            modalProduto.classList.add(
                "hidden"
            );


            alert(
                produtoSelecionado.nome +
                " foi adicionado ao carrinho!"
            );

        }
    );

}