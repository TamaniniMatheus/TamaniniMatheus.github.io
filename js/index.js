```javascript
// ==========================================
// PÁGINA INICIAL - REI DO AÇAÍ
// ==========================================


// Botão "Ver Cardápio"

const btnCardapio = document.getElementById("btnCardapio");

if (btnCardapio) {

    btnCardapio.addEventListener("click", function () {

        window.location.href = "cliente/cardapio.php";

    });

}


// ==========================================
// BOTÕES DE CATEGORIA
// ==========================================

const botoesCategoria = document.querySelectorAll(".categoria-btn");

botoesCategoria.forEach(function (botao) {

    botao.addEventListener("click", function () {

        const categoria = botao.dataset.categoria;

        if (categoria === "Todos") {

            window.location.href = "cliente/cardapio.php";

        } else {

            window.location.href =
                "cliente/cardapio.php?categoria=" +
                encodeURIComponent(categoria);

        }

    });

});
```
