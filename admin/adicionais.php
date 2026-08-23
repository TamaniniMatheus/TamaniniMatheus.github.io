<?php

session_start();

if (!isset($_SESSION["ID_CLI"]) || $_SESSION["ID_CLI"] != 1) {
    header("Location: ../loginusuario.php");
    exit;
}

require_once "../config/conexao.php";

$sql = "SELECT ID_ADC, NOME_ADC, TIPO_ADC, VALOR_ADC, ESTOQUE, IMAGEM FROM ADICIONAL ORDER BY ID_ADC DESC";
$resultado = $conexao->query($sql);

$mensagens_sucesso = [
    "cadastro" => "Adicional cadastrado com sucesso!",
    "edicao"   => "Adicional atualizado com sucesso!",
    "exclusao" => "Adicional excluído com sucesso!",
];

$mensagem_sucesso = null;
foreach (["cadastro", "edicao", "exclusao"] as $chave) {
    if (($_GET[$chave] ?? "") === "sucesso") {
        $mensagem_sucesso = $mensagens_sucesso[$chave];
        break;
    }
}

$mensagens_erro = [
    "adicionalemuso"    => "Este adicional não pode ser excluído porque já está vinculado a um ou mais pedidos.",
    "exclusao"          => "Não foi possível excluir o adicional. Tente novamente.",
    "adicionalinvalido" => "Adicional inválido.",
];

$erro = $_GET["erro"] ?? "";
$mensagem_erro = $mensagens_erro[$erro] ?? null;

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionais | Rei do Açaí</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- MENU LATERAL -->
    <aside class="fixed left-0 top-0 h-screen w-64 bg-purple-800 text-white">

        <div class="px-6 py-7 border-b border-purple-700">
            <h1 class="text-2xl font-bold">Rei do Açaí</h1>
            <p class="text-purple-200 text-sm mt-1">Painel administrativo</p>
        </div>

        <nav class="px-4 py-5">

    <a
        href="index.php"
        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition duration-200 mb-2"
    >
        <span class="text-lg">🏠</span>
        <span>Início</span>
    </a>

    <a
        href="produtos.php"
        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition duration-200 mb-2"
    >
        <span class="text-lg">📦</span>
        <span>Produtos</span>
    </a>

    <a
        href="adicionais.php"
        class="flex items-center gap-3 px-4 py-3 rounded-lg bg-purple-700 mb-2"
    >
        <span class="text-lg">🥣</span>
        <span>Adicionais</span>
    </a>

    <a
        href="pedidos.php"
        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition duration-200 mb-2"
    >
        <span class="text-lg">🧾</span>
        <span>Pedidos</span>
    </a>

    <a
        href="clientes.php"
        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition duration-200 mb-2"
    >
        <span class="text-lg">👥</span>
        <span>Clientes</span>
    </a>

    <a
        href="relatorio.php"
        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition duration-200 mb-2"
    >
        <span class="text-lg">📊</span>
        <span>Relatórios</span>
    </a>

</nav>

        <div class="absolute bottom-0 left-0 w-full p-4 border-t border-purple-700">
            <a href="../index.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition duration-200">
                <span class="text-lg">←</span>
                <span>Voltar para o site</span>
            </a>
        </div>

    </aside>

    <!-- CONTEÚDO PRINCIPAL -->
    <main class="ml-64 p-8">

        <!-- CABEÇALHO -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <p class="text-sm text-purple-700 font-medium mb-1">Gerenciamento</p>
                <h2 class="text-3xl font-bold text-gray-800">Adicionais</h2>
                <p class="text-gray-500 mt-1">Cadastre e gerencie os adicionais do Rei do Açaí.</p>
            </div>

            <a href="cadastro_adicional.php" class="inline-flex items-center gap-2 bg-purple-700 hover:bg-purple-800 text-white font-medium px-5 py-3 rounded-lg shadow-sm hover:shadow transition duration-200">
                <span class="text-lg">+</span>
                Cadastrar adicional
            </a>
        </div>

        <?php if ($mensagem_sucesso): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3 mb-6"><?php echo htmlspecialchars($mensagem_sucesso); ?></div>
        <?php endif; ?>

        <?php if ($mensagem_erro): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-6"><?php echo htmlspecialchars($mensagem_erro); ?></div>
        <?php endif; ?>

        <!-- CARD PRINCIPAL -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="px-6 py-5 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Adicionais cadastrados</h3>
                        <p class="text-sm text-gray-500 mt-1">Confira os adicionais atualmente disponíveis.</p>
                    </div>
                    <div class="bg-purple-50 text-purple-700 px-4 py-2 rounded-lg">
                        <span class="text-sm font-medium"><?php echo $resultado ? $resultado->num_rows : 0; ?> adicional(is)</span>
                    </div>
                </div>
            </div>

            <!-- TABELA -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Adicional</th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipo</th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Valor</th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Estoque</th>
                            <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        <?php if ($resultado && $resultado->num_rows > 0): ?>
                            <?php while ($adicional = $resultado->fetch_assoc()): ?>

                                <tr class="hover:bg-gray-50 transition duration-150">

                                    <!-- ADICIONAL -->
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="w-14 h-14 rounded-xl bg-purple-50 overflow-hidden flex items-center justify-center border border-gray-100">
                                                <?php if (!empty($adicional["IMAGEM"])): ?>
                                                    <img src="../<?php echo htmlspecialchars($adicional["IMAGEM"]); ?>" alt="<?php echo htmlspecialchars($adicional["NOME_ADC"]); ?>" class="w-full h-full object-cover">
                                                <?php else: ?>
                                                    <span class="text-2xl">🥣</span>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800"><?php echo htmlspecialchars($adicional["NOME_ADC"]); ?></p>
                                                <p class="text-sm text-gray-400 mt-1">Código: #<?php echo $adicional["ID_ADC"]; ?></p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- TIPO -->
                                    <td class="px-6 py-5">
                                        <span class="text-gray-600"><?php echo htmlspecialchars($adicional["TIPO_ADC"] ?? "—"); ?></span>
                                    </td>

                                    <!-- VALOR -->
                                    <td class="px-6 py-5">
                                        <span class="font-semibold text-gray-800">R$ <?php echo number_format($adicional["VALOR_ADC"], 2, ",", "."); ?></span>
                                    </td>

                                    <!-- ESTOQUE -->
                                    <td class="px-6 py-5">
                                        <?php if ($adicional["ESTOQUE"] > 0): ?>
                                            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-medium bg-green-100 text-green-700">
                                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                                <?php echo $adicional["ESTOQUE"]; ?> unidades
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-medium bg-red-100 text-red-700">
                                                <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                                Sem estoque
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- AÇÕES -->
                                    <td class="px-6 py-5 text-right">
                                        <a href="editar_adicional.php?id=<?php echo $adicional["ID_ADC"]; ?>" class="inline-flex items-center text-sm font-medium text-purple-700 hover:text-purple-900 mr-4 transition">Editar</a>
                                        <form action="../processa/excluir_adicional.php" method="POST" class="inline" onsubmit="return confirm('Excluir o adicional &quot;<?php echo htmlspecialchars($adicional["NOME_ADC"], ENT_QUOTES); ?>&quot;? Essa ação não pode ser desfeita.');">
                                            <input type="hidden" name="id_adc" value="<?php echo $adicional["ID_ADC"]; ?>">
                                            <button type="submit" class="inline-flex items-center text-sm font-medium text-red-600 hover:text-red-800 transition">Excluir</button>
                                        </form>
                                    </td>

                                </tr>

                            <?php endwhile; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 flex items-center justify-center bg-purple-50 rounded-full text-3xl mb-4">🥣</div>
                                        <h3 class="font-semibold text-gray-800">Nenhum adicional cadastrado</h3>
                                        <p class="text-gray-500 text-sm mt-1">Comece cadastrando o primeiro adicional.</p>
                                    </div>
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- OBSERVAÇÃO -->
        <div class="mt-6 flex items-start gap-3 bg-purple-50 border border-purple-100 rounded-xl p-5">
            <span class="text-xl">💡</span>
            <div>
                <h4 class="font-semibold text-purple-800">Gerenciamento de adicionais</h4>
                <p class="text-sm text-purple-700 mt-1">
                    Nesta área você poderá cadastrar novos adicionais, alterar informações, controlar o estoque e remover adicionais quando necessário.
                </p>
            </div>
        </div>

    </main>

</body>
</html>