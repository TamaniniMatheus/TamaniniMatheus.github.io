document.addEventListener("DOMContentLoaded", function () {

    // ==================================================
    // GRÁFICO DE STATUS DOS PEDIDOS
    // ==================================================

    const elementoStatus = document.getElementById("graficoStatus");

    if (elementoStatus) {

        const labelsStatus = Object.keys(dadosStatus);
        const valoresStatus = Object.values(dadosStatus);

        new Chart(elementoStatus, {

            type: "doughnut",

            data: {

                labels: labelsStatus,

                datasets: [{
                    data: valoresStatus
                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        position: "bottom"
                    }

                }
            }

        });

    }


    // ==================================================
    // GRÁFICO DE PRODUTOS MAIS VENDIDOS
    // ==================================================

    const elementoProdutos = document.getElementById("graficoProdutos");

    if (elementoProdutos) {

        const labelsProdutos = dadosProdutos.map(
            produto => produto.nome
        );

        const valoresProdutos = dadosProdutos.map(
            produto => produto.quantidade
        );


        new Chart(elementoProdutos, {

            type: "bar",

            data: {

                labels: labelsProdutos,

                datasets: [{

                    label: "Quantidade vendida",

                    data: valoresProdutos

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                indexAxis: "y",

                scales: {

                    x: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }

                },

                plugins: {

                    legend: {
                        display: false
                    }

                }

            }

        });

    }

});