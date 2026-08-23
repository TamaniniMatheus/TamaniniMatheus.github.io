```javascript
// ==========================================
// CARDÁPIO - REI DO AÇAÍ
// ==========================================

const botoesProduto = document.querySelectorAll(".btn-produto");

const modalProduto = document.getElementById("modalProduto");

const fecharModal = document.getElementById("fecharModal");

const modalNome = document.getElementById("modalNome");

const quantidadeProduto = document.getElementById("quantidadeProduto");

const aumentarQuantidade =
    document.getElementById("aumentarQuantidade");

const diminuirQuantidade =
    document.getElementById("diminuirQuantidade");

const adicionarCarrinho =
    document.getElementById("adicionarCarrinho");


let produtoSelecionado = null;

let quantidade = 1;


// ==========================================
// ABRIR MODAL
// ==========================================

botoesProduto.forEach(function (botao) {

    botao.addEventListener("click", function () {

        produtoSelecionado = {

            id: botao.dataset.id,

            nome: botao.dataset.nome,

            preco: parseFloat(botao.dataset.preco)

        };


        quantidade = 1;

        quantidadeProduto.textContent = quantidade;

        modalNome.textContent =
            produtoSelecionado.nome;


        modalProduto.classList.remove("hidden");

    });

});


// ==========================================
// FECHAR MODAL
// ==========================================

fecharModal.addEventListener("click", function () {

    modalProduto.classList.add("hidden");

});


// Fechar clicando fora do modal

modalProduto.addEventListener("click", function (evento) {

    if (evento.target === modalProduto) {

        modalProduto.classList.add("hidden");

    }

});


// ==========================================
// AUMENTAR QUANTIDADE
// ==========================================

aumentarQuantidade.addEventListener("click", function () {

    quantidade++;

    quantidadeProduto.textContent = quantidade;

});


// ==========================================
// DIMINUIR QUANTIDADE
// ==========================================

diminuirQuantidade.addEventListener("click", function () {

    if (quantidade > 1) {

        quantidade--;

        quantidadeProduto.textContent = quantidade;

    }

});


// ==========================================
// ADICIONAR AO CARRINHO
// ==========================================

adicionarCarrinho.addEventListener("click", function () {

    if (!produtoSelecionado) {

        return;

    }


    let carrinho =
        JSON.parse(localStorage.getItem("carrinho")) || [];


    const produtoExistente =
        carrinho.find(function (item) {

            return item.id === produtoSelecionado.id;

        });


    if (produtoExistente) {

        produtoExistente.quantidade += quantidade;

    } else {

        carrinho.push({

            id: produtoSelecionado.id,

            nome: produtoSelecionado.nome,

            preco: produtoSelecionado.preco,

            quantidade: quantidade,

            adicionais: []

        });

    }


    localStorage.setItem(
        "carrinho",
        JSON.stringify(carrinho)
    );


    modalProduto.classList.add("hidden");


    alert("Produto adicionado ao carrinho!");

});
```
