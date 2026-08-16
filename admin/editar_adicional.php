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

$stmt = $conexao->prepare("SELECT ID_ADC, NOME_ADC, TIPO_ADC, VALOR_ADC, ESTOQUE, IMAGEM FROM ADICIONAL WHERE ID_ADC = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($id_adc, $nome_adc, $tipo_adc, $valor_adc, $estoque_adc, $imagem_adc);
$encontrado = $stmt->fetch();
$stmt->close();

if (!$encontrado) {
    header("Location: adicionais.php");
    exit;
}

$mensagens_erro = [
    "preenchimento" => "Preencha todos os campos obrigatórios.",
    "valor"         => "Valor ou estoque inválido.",
    "imagem"        => "A imagem enviada não é válida.",
    "formato"       => "Formato de imagem não permitido (use jpg, jpeg, png ou webp).",
    "upload"        => "Não foi possível salvar a imagem enviada.",
    "banco"         => "Erro ao salvar as alterações no banco de dados.",
];

$erro = $_GET["erro"] ?? "";
$mensagem_erro = $mensagens_erro[$erro] ?? null;

$tipos_disponiveis = ["Cremes", "Frutas", "Caldas", "Outros"];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Adicional | Rei do Açaí</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-purple-700 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-8">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-purple-700">REI DO AÇAÍ</h1>
            <p class="text-gray-500 mt-2">Editar adicional #<?php echo $id_adc; ?></p>
        </div>

        <?php if ($mensagem_erro): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-5"><?php echo htmlspecialchars($mensagem_erro); ?></div>
        <?php endif; ?>

        <?php if (!empty($imagem_adc)): ?>
            <div class="flex justify-center mb-5">
                <img src="../<?php echo htmlspecialchars($imagem_adc); ?>" alt="Imagem atual" class="w-20 h-20 rounded-xl object-cover border border-gray-200">
            </div>
        <?php endif; ?>

        <form action="../processa/editar_adicional.php" method="POST" enctype="multipart/form-data" class="space-y-4">

            <input type="hidden" name="id_adc" value="<?php echo $id_adc; ?>">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nome do adicional</label>
                <input type="text" name="nome_adc" required maxlength="30" value="<?php echo htmlspecialchars($nome_adc); ?>" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-600">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tipo</label>
                <select name="tipo_adc" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-600">
                    <?php foreach ($tipos_disponiveis as $tipo): ?>
                        <option value="<?php echo htmlspecialchars($tipo); ?>" <?php echo ($tipo_adc === $tipo) ? "selected" : ""; ?>><?php echo htmlspecialchars($tipo); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Valor (R$)</label>
                    <input type="number" name="valor_adc" required min="0" step="0.01" value="<?php echo htmlspecialchars($valor_adc); ?>" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-600">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Estoque</label>
                    <input type="number" name="estoque" required min="0" step="1" value="<?php echo htmlspecialchars($estoque_adc); ?>" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-600">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nova imagem (opcional)</label>
                <input type="file" name="imagem" accept=".jpg,.jpeg,.png,.webp" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-600">
                <p class="text-xs text-gray-400 mt-1">Deixe em branco para manter a imagem atual.</p>
            </div>

            <button type="submit" class="w-full bg-purple-700 hover:bg-purple-800 text-white font-bold py-3 rounded-lg transition duration-300">Salvar alterações</button>

        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            <a href="adicionais.php" class="text-purple-700 font-semibold hover:underline">← Voltar para adicionais</a>
        </p>

    </div>

</body>
</html>