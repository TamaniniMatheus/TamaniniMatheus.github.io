<?php

session_start();

if (!isset($_SESSION["ID_CLI"]) || $_SESSION["ID_CLI"] != 1) {
    header("Location: ../loginusuario.php");
    exit;
}

require_once "../config/conexao.php";

$status_disponiveis = ["Recebido", "Em preparo", "Saiu para entrega", "Entregue", "Cancelado"];

$sql_pedidos = "SELECT p.ID_PED, p.STATUS_PED, p.METODO_PAG, p.VALOR_TOTAL, p.DATA_PED,
                        c.NOME_CLI, e.RUA, e.NUMERO, e.BAIRRO, e.CIDADE
                 FROM PEDIDO p
                 JOIN CLIENTE c ON p.COD_CLI = c.ID_CLI
                 JOIN ENDERECO e ON p.COD_END = e.ID_END
                 ORDER BY p.DATA_PED DESC";

$pedidos = $conexao->query($sql_pedidos);

$mensagens_sucesso = ["status" => "Status do pedido atualizado com sucesso!"];
$mensagem_sucesso = ($_GET["status"] ?? "") === "sucesso" ? $mensagens_sucesso["status"] : null;

$mensagens_erro = ["statusinvalido" => "Status inválido.", "pedidoinvalido" => "Pedido inválido."];
$erro = $_GET["erro"] ?? "";
$mensagem_erro = $mensagens_erro[$erro] ?? null;

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos | Rei do Açaí</title>
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
            <a href="index.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition duration-200 mb-2">
                <span class="text-lg">🏠</span><span>Início</span>
            </a>
            <a href="produtos.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition duration-200 mb-2">
                <span class="text-lg">📦</span><span>Produtos</span>
            </a>
            <a href="adicionais.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition duration-200 mb-2">
                <span class="text-lg">🥣</span><span>Adicionais</span>
            </a>
            <a href="pedidos.php" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-purple-700 mb-2">
                <span class="text-lg">🧾</span><span>Pedidos</span>
            </a>
            <a href="clientes.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition duration-200 mb-2">
                <span class="text-lg">👥</span><span>Clientes</span>
            </a>
            <a href="relatorio.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition duration-200 mb-2">
                <span class="text-lg">📊</span><span>Relatórios</span>
            </a>
        </nav>
        <div class="absolute bottom-0 left-0 w-full p-4 border-t border-purple-700">
            <a href="../index.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition duration-200">
                <span class="text-lg">←</span><span>Voltar para o site</span>
            </a>
        </div>
    </aside>

    <!-- CONTEÚDO PRINCIPAL -->
    <main class="ml-64 p-8">

        <div class="mb-8">
            <p class="text-sm text-purple-700 font-medium mb-1">Gerenciamento</p>
            <h2 class="text-3xl font-bold text-gray-800">Pedidos</h2>
            <p class="text-gray-500 mt-1">Acompanhe e atualize o status dos pedidos recebidos.</p>
        </div>

        <?php if ($mensagem_sucesso): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3 mb-6"><?php echo htmlspecialchars($mensagem_sucesso); ?></div>
        <?php endif; ?>

        <?php if ($mensagem_erro): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-6"><?php echo htmlspecialchars($mensagem_erro); ?></div>
        <?php endif; ?>

        <?php if ($pedidos && $pedidos->num_rows > 0): ?>

            <div class="space-y-4">
                <?php while ($pedido = $pedidos->fetch_assoc()): ?>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

                        <div class="flex flex-wrap items-start justify-between gap-4 mb-4">
                            <div>
                                <p class="font-semibold text-gray-800">Pedido #<?php echo $pedido["ID_PED"]; ?> — <?php echo htmlspecialchars($pedido["NOME_CLI"]); ?></p>
                                <p class="text-sm text-gray-500 mt-1"><?php echo date("d/m/Y H:i", strtotime($pedido["DATA_PED"])); ?> · <?php echo htmlspecialchars($pedido["METODO_PAG"]); ?></p>
                                <p class="text-sm text-gray-500 mt-1"><?php echo htmlspecialchars($pedido["RUA"] . ", " . $pedido["NUMERO"] . " — " . $pedido["BAIRRO"] . ", " . $pedido["CIDADE"]); ?></p>
                            </div>

                            <form action="../processa/atualizar_status_pedido.php" method="POST" class="flex items-center gap-2">
                                <input type="hidden" name="id_ped" value="<?php echo $pedido["ID_PED"]; ?>">
                                <select name="status_ped" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-600">
                                    <?php foreach ($status_disponiveis as $status): ?>
                                        <option value="<?php echo htmlspecialchars($status); ?>" <?php echo ($pedido["STATUS_PED"] === $status) ? "selected" : ""; ?>><?php echo htmlspecialchars($status); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="bg-purple-700 hover:bg-purple-800 text-white text-sm font-medium px-4 py-2 rounded-lg transition">Atualizar</button>
                            </form>
                        </div>

                        <?php
                        $stmt_itens = $conexao->prepare("
                            SELECT i.QUANTIDADE, i.SUBTOTAL, pr.NOME_PROD, ad.NOME_ADC
                            FROM ITEM_PEDIDO i
                            JOIN PRODUTO pr ON i.COD_PROD = pr.ID_PROD
                            LEFT JOIN ADICIONAL ad ON i.COD_ADC = ad.ID_ADC
                            WHERE i.COD_PED = ?
                        ");
                        $stmt_itens->bind_param("i", $pedido["ID_PED"]);
                        $stmt_itens->execute();
                        $stmt_itens->bind_result($qtd_item, $subtotal_item, $nome_prod_item, $nome_adc_item);
                        ?>

                        <div class="border-t border-gray-100 pt-3 space-y-1">
                            <?php while ($stmt_itens->fetch()): ?>
                                <p class="text-sm text-gray-600">
                                    <?php echo $qtd_item; ?>x <?php echo htmlspecialchars($nome_prod_item); ?>
                                    <?php if (!empty($nome_adc_item)): ?> + <?php echo htmlspecialchars($nome_adc_item); ?><?php endif; ?>
                                    — R$ <?php echo number_format($subtotal_item, 2, ",", "."); ?>
                                </p>
                            <?php endwhile; ?>
                            <?php $stmt_itens->close(); ?>
                        </div>

                        <div class="border-t border-gray-100 mt-3 pt-3 flex items-center justify-between">
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700"><?php echo htmlspecialchars($pedido["STATUS_PED"]); ?></span>
                            <span class="font-semibold text-gray-800">Total: R$ <?php echo number_format($pedido["VALOR_TOTAL"], 2, ",", "."); ?></span>
                        </div>

                    </div>

                <?php endwhile; ?>
            </div>

        <?php else: ?>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
                <div class="w-16 h-16 mx-auto flex items-center justify-center bg-purple-50 rounded-full text-3xl mb-4">🧾</div>
                <h3 class="font-semibold text-gray-800">Nenhum pedido recebido ainda</h3>
                <p class="text-gray-500 text-sm mt-1">Assim que um cliente fizer um pedido, ele aparece aqui.</p>
            </div>

        <?php endif; ?>

    </main>

</body>
</html>