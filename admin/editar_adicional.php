<?php

session_start();

if (!isset($_SESSION["ID_CLI"]) || $_SESSION["ID_CLI"] != 1) {
    header("Location: ../loginusuario.php");
    exit;
}

require_once "../config/conexao.php";

$id = $_GET["id"] ?? "";

if (!is_numeric($id)) {
    header("Location: adicionais.php");
    exit;
}

$stmt = $conexao->prepare("
    SELECT ID_ADC, NOME_ADC, TIPO_ADC, VALOR_ADC, ESTOQUE, IMAGEM
    FROM ADICIONAL
    WHERE ID_ADC = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$stmt->bind_result(
    $id_adc,
    $nome_adc,
    $tipo_adc,
    $valor_adc,
    $estoque_adc,
    $imagem_adc
);

if (!$stmt->fetch()) {
    $stmt->close();
    header("Location: adicionais.php");
    exit;
}

$stmt->close();

$mensagens = [
    "preenchimento" => "Preencha todos os campos obrigatórios.",
    "valor" => "Verifique o valor e o estoque informados.",
    "imagem" => "A imagem enviada não é válida.",
    "formato" => "Use uma imagem JPG, JPEG, PNG ou WEBP.",
    "upload" => "Não foi possível salvar a imagem.",
    "banco" => "Não foi possível salvar as alterações."
];

$erro = $_GET["erro"] ?? "";
$mensagem = $mensagens[$erro] ?? null;

$tipos = [
    "Creme",
    "Fruta",
    "Chocolate",
    "Confeitaria",
    "Calda",
    "Outro"
];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Adicional | Rei do Açaí</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 min-h-screen">


    <aside class="fixed left-0 top-0 h-screen w-64 bg-purple-800 text-white">

        <div class="px-6 py-7 border-b border-purple-700">

            <h1 class="text-2xl font-bold">
                Rei do Açaí
            </h1>

            <p class="text-purple-200 text-sm mt-1">
                Painel administrativo
            </p>

        </div>

        <nav class="px-4 py-5">

            <a href="index.php"
               class="flex items-center gap-3 px-4 py-3 rounded-lg
                      hover:bg-purple-700 transition mb-2">
                🏠
                <span>Início</span>
            </a>

            <a href="produtos.php"
               class="flex items-center gap-3 px-4 py-3 rounded-lg
                      hover:bg-purple-700 transition mb-2">
                📦
                <span>Produtos</span>
            </a>

            <a href="adicionais.php"
               class="flex items-center gap-3 px-4 py-3 rounded-lg
                      bg-purple-700 mb-2">
                🥣
                <span>Adicionais</span>
            </a>

            <a href="clientes.php"
               class="flex items-center gap-3 px-4 py-3 rounded-lg
                      hover:bg-purple-700 transition mb-2">
                👥
                <span>Clientes</span>
            </a>

            <a href="relatorio.php"
               class="flex items-center gap-3 px-4 py-3 rounded-lg
                      hover:bg-purple-700 transition mb-2">
                📊
                <span>Relatórios</span>
            </a>

        </nav>

        <div class="absolute bottom-0 left-0 w-full
                    p-4 border-t border-purple-700">

            <a href="../index.php"
               class="flex items-center gap-3 px-4 py-3 rounded-lg
                      hover:bg-purple-700 transition">
                ←
                <span>Voltar para o site</span>
            </a>

        </div>

    </aside>


    <main class="ml-64 p-8">

        <div class="max-w-4xl mx-auto">

            <div class="mb-8">

                <p class="text-sm text-purple-700 font-medium mb-1">
                    Adicionais
                </p>

                <h2 class="text-3xl font-bold text-gray-800">
                    Editar adicional
                </h2>

                <p class="text-gray-500 mt-1">
                    Atualize as informações do adicional selecionado.
                </p>

            </div>


            <?php if ($mensagem): ?>

                <div class="mb-6 bg-red-50 border border-red-200
                            text-red-700 rounded-xl px-5 py-4">

                    <?php echo htmlspecialchars($mensagem); ?>

                </div>

            <?php endif; ?>


            <form
                action="../processa/editar_adicional.php"
                method="POST"
                enctype="multipart/form-data"
                class="bg-white rounded-2xl shadow-sm
                       border border-gray-100 p-8"
            >

                <input
                    type="hidden"
                    name="id_adc"
                    value="<?php echo $id_adc; ?>"
                >


                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                    <div class="md:col-span-2">

                        <label
                            for="nome_adc"
                            class="block text-sm font-medium
                                   text-gray-700 mb-2"
                        >
                            Nome do adicional
                        </label>

                        <input
                            type="text"
                            id="nome_adc"
                            name="nome_adc"
                            maxlength="30"
                            required
                            value="<?php echo htmlspecialchars($nome_adc); ?>"
                            class="w-full px-4 py-3
                                   border border-gray-300 rounded-lg
                                   focus:outline-none
                                   focus:ring-2 focus:ring-purple-500"
                        >

                    </div>


                    <div>

                        <label
                            for="tipo_adc"
                            class="block text-sm font-medium
                                   text-gray-700 mb-2"
                        >
                            Tipo do adicional
                        </label>

                        <select
                            id="tipo_adc"
                            name="tipo_adc"
                            required
                            class="w-full px-4 py-3
                                   border border-gray-300 rounded-lg
                                   focus:outline-none
                                   focus:ring-2 focus:ring-purple-500"
                        >

                            <?php foreach ($tipos as $tipo): ?>

                                <option
                                    value="<?php echo htmlspecialchars($tipo); ?>"
                                    <?php echo $tipo_adc === $tipo ? "selected" : ""; ?>
                                >
                                    <?php echo htmlspecialchars($tipo); ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <div>

                        <label
                            for="valor_adc"
                            class="block text-sm font-medium
                                   text-gray-700 mb-2"
                        >
                            Valor
                        </label>

                        <div class="relative">

                            <span class="absolute left-4 top-1/2
                                         -translate-y-1/2 text-gray-500">
                                R$
                            </span>

                            <input
                                type="number"
                                id="valor_adc"
                                name="valor_adc"
                                min="0"
                                step="0.01"
                                required
                                value="<?php echo htmlspecialchars($valor_adc); ?>"
                                class="w-full pl-12 pr-4 py-3
                                       border border-gray-300 rounded-lg
                                       focus:outline-none
                                       focus:ring-2 focus:ring-purple-500"
                            >

                        </div>

                    </div>


                    <div>

                        <label
                            for="estoque"
                            class="block text-sm font-medium
                                   text-gray-700 mb-2"
                        >
                            Estoque
                        </label>

                        <input
                            type="number"
                            id="estoque"
                            name="estoque"
                            min="0"
                            required
                            value="<?php echo htmlspecialchars($estoque_adc); ?>"
                            class="w-full px-4 py-3
                                   border border-gray-300 rounded-lg
                                   focus:outline-none
                                   focus:ring-2 focus:ring-purple-500"
                        >

                    </div>


                    <div>

                        <label
                            for="imagem"
                            class="block text-sm font-medium
                                   text-gray-700 mb-2"
                        >
                            Nova imagem
                        </label>

                        <input
                            type="file"
                            id="imagem"
                            name="imagem"
                            accept=".jpg,.jpeg,.png,.webp"
                            class="w-full px-4 py-2.5
                                   border border-gray-300 rounded-lg
                                   text-sm"
                        >

                        <p class="text-xs text-gray-400 mt-2">
                            Deixe vazio para manter a imagem atual.
                        </p>

                    </div>

                </div>


                <?php if (!empty($imagem_adc)): ?>

                    <div class="mt-6">

                        <p class="text-sm font-medium text-gray-700 mb-2">
                            Imagem atual
                        </p>

                        <img
                            id="imagemAtual"
                            src="../<?php echo htmlspecialchars($imagem_adc); ?>"
                            alt="Imagem atual do adicional"
                            class="w-28 h-28 object-cover rounded-xl
                                   border border-gray-200"
                        >

                    </div>

                <?php endif; ?>


                <div class="border-t border-gray-100 mt-8 pt-6">

                    <div class="flex flex-col-reverse sm:flex-row
                                justify-end gap-3">

                        <a
                            href="adicionais.php"
                            class="px-5 py-3 text-center rounded-lg
                                   border border-gray-300 text-gray-700
                                   hover:bg-gray-50"
                        >
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            class="px-6 py-3 rounded-lg
                                   bg-purple-700 hover:bg-purple-800
                                   text-white font-medium transition"
                        >
                            Salvar alterações
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </main>


    <script>

        const campoImagem = document.getElementById("imagem");

        campoImagem?.addEventListener("change", function () {

            const arquivo = this.files[0];

            if (!arquivo) {
                return;
            }

            if (!arquivo.type.startsWith("image/")) {

                alert("Selecione uma imagem válida.");

                this.value = "";

                return;
            }

            const imagemAtual = document.getElementById("imagemAtual");

            if (imagemAtual) {
                imagemAtual.src = URL.createObjectURL(arquivo);
            }

        });

    </script>

</body>

</html>