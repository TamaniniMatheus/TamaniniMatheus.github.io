<?php

session_start();

if (!isset($_SESSION["ID_CLI"]) || $_SESSION["ID_CLI"] != 1) {
    header("Location: ../loginusuario.php");
    exit;
}

$mensagens_erro = [
    "preenchimento" => "Preencha todos os campos obrigatórios.",
    "valor"         => "Valor ou estoque inválido.",
    "imagem"        => "A imagem enviada não é válida.",
    "formato"       => "Formato de imagem não permitido (use jpg, jpeg, png ou webp).",
    "upload"        => "Não foi possível salvar a imagem enviada.",
    "banco"         => "Erro ao salvar o produto no banco de dados.",
];

$erro = $_GET["erro"] ?? "";
$mensagem_erro = $mensagens_erro[$erro] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto | Rei do Açaí</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-purple-700 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-8">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-purple-700">REI DO AÇAÍ</h1>
            <p class="text-gray-500 mt-2">Cadastrar novo produto</p>
        </div>

        <?php if ($mensagem_erro): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-5">
                <?php echo htmlspecialchars($mensagem_erro); ?>
            </div>
        <?php endif; ?>

        <form action="../processa/cadastro_produto.php" method="POST" enctype="multipart/form-data" class="space-y-4">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nome do produto</label>
                <input type="text" name="nome_prod" required maxlength="100" placeholder="Ex: Açaí 500ml" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-600">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tipo</label>
                <input type="text" name="tipo_prod" required maxlength="50" placeholder="Ex: Copo, Adicional, Bebida" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-600">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Valor (R$)</label>
                    <input type="number" name="valor_prod" required min="0" step="0.01" placeholder="0.00" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-600">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Estoque</label>
                    <input type="number" name="estoque" required min="0" step="1" placeholder="0" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-600">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Imagem do produto</label>
                <input type="file" name="imagem" accept=".jpg,.jpeg,.png,.webp" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-600">
                <p class="text-xs text-gray-400 mt-1">Formatos aceitos: JPG, JPEG, PNG ou WEBP (opcional).</p>
            </div>

            <button type="submit" class="w-full bg-purple-700 hover:bg-purple-800 text-white font-bold py-3 rounded-lg transition duration-300">
                Cadastrar produto
            </button>

        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            <a href="produtos.php" class="text-purple-700 font-semibold hover:underline">← Voltar para produtos</a>
        </p>

    </div>

</body>
</html>