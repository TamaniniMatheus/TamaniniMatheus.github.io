<?php

require_once "../config/conexao.php";


// Verifica se já existe uma sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Verifica se existe usuário logado
if (!isset($_SESSION["ID_CLI"])) {
    header("Location: ../loginusuario.php");
    exit;
}


// Verifica se é administrador
if ($_SESSION["ID_CLI"] != 1) {
    header("Location: ../index.php");
    exit;
}


// Pesquisa
$pesquisa = trim($_GET["pesquisa"] ?? "");


if ($pesquisa !== "") {

    $sql = "SELECT
                ID_CLI,
                NOME_CLI,
                CPF_CLI,
                TEL_CLI,
                EMAIL_CLI,
                USUARIO
            FROM CLIENTE
            WHERE NOME_CLI LIKE ?
               OR EMAIL_CLI LIKE ?
               OR USUARIO LIKE ?
            ORDER BY ID_CLI ASC";

    $stmt = $conexao->prepare($sql);

    if (!$stmt) {
        die("Erro ao preparar consulta: " . $conexao->error);
    }

    $termo = "%" . $pesquisa . "%";

    $stmt->bind_param(
        "sss",
        $termo,
        $termo,
        $termo
    );

    $stmt->execute();

    $clientes = $stmt->get_result();

} else {

    $sql = "SELECT
                ID_CLI,
                NOME_CLI,
                CPF_CLI,
                TEL_CLI,
                EMAIL_CLI,
                USUARIO
            FROM CLIENTE
            ORDER BY ID_CLI ASC";

    $clientes = $conexao->query($sql);

    if (!$clientes) {
        die("Erro ao consultar clientes: " . $conexao->error);
    }
}

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Clientes | Rei do Açaí</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-gray-100 min-h-screen">


    <!-- CABEÇALHO -->

    <header class="bg-purple-700 text-white shadow-md">

        <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">

            <div>

                <h1 class="text-2xl font-bold">
                    Rei do Açaí
                </h1>

                <p class="text-purple-200 text-sm">
                    Gerenciamento de clientes
                </p>

            </div>


            <a
                href="index.php"
                class="bg-white text-purple-700 px-4 py-2 rounded-lg font-semibold hover:bg-purple-50 transition"
            >
                Voltar ao painel
            </a>

        </div>

    </header>



    <!-- CONTEÚDO -->

    <main class="max-w-7xl mx-auto px-6 py-8">


        <!-- TÍTULO -->

        <div class="mb-8">

            <h2 class="text-3xl font-bold text-gray-800">
                Clientes
            </h2>

            <p class="text-gray-500 mt-1">
                Consulte os clientes cadastrados no sistema.
            </p>

        </div>



        <!-- PESQUISA -->

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">

            <form
                method="GET"
                action="clientes.php"
                class="flex flex-col md:flex-row gap-3"
            >

                <div class="flex-1">

                    <label
                        for="pesquisa"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Pesquisar cliente
                    </label>


                    <input
                        type="text"
                        id="pesquisa"
                        name="pesquisa"
                        value="<?= htmlspecialchars($pesquisa) ?>"
                        placeholder="Nome, usuário ou e-mail..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    >

                </div>


                <div class="flex items-end gap-2">

                    <button
                        type="submit"
                        class="px-6 py-3 bg-purple-600 text-white rounded-xl font-semibold hover:bg-purple-700 transition"
                    >
                        Pesquisar
                    </button>


                    <?php if ($pesquisa !== ""): ?>

                        <a
                            href="clientes.php"
                            class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition"
                        >
                            Limpar
                        </a>

                    <?php endif; ?>

                </div>

            </form>

        </div>



        <!-- TABELA -->

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

            <div class="px-6 py-5 border-b border-gray-200">

                <h3 class="text-lg font-bold text-gray-800">
                    Clientes cadastrados
                </h3>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                ID
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                Nome
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                Usuário
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                E-mail
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                Telefone
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">
                                Tipo
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100">


                        <?php if ($clientes && $clientes->num_rows > 0): ?>


                            <?php while ($cliente = $clientes->fetch_assoc()): ?>


                                <tr class="hover:bg-gray-50 transition">


                                    <!-- ID -->

                                    <td class="px-6 py-4">

                                        <span class="font-semibold text-gray-700">

                                            #<?= htmlspecialchars($cliente["ID_CLI"]) ?>

                                        </span>

                                    </td>



                                    <!-- NOME -->

                                    <td class="px-6 py-4">

                                        <?php

                                        if (!empty($cliente["NOME_CLI"])) {

                                            echo htmlspecialchars(
                                                $cliente["NOME_CLI"]
                                            );

                                        } else {

                                            echo '<span class="text-gray-400">
                                                    Não informado
                                                  </span>';

                                        }

                                        ?>

                                    </td>



                                    <!-- USUÁRIO -->

                                    <td class="px-6 py-4 text-gray-700">

                                        <?= htmlspecialchars(
                                            $cliente["USUARIO"]
                                        ) ?>

                                    </td>



                                    <!-- EMAIL -->

                                    <td class="px-6 py-4 text-gray-600">

                                        <?= htmlspecialchars(
                                            $cliente["EMAIL_CLI"]
                                        ) ?>

                                    </td>



                                    <!-- TELEFONE -->

                                    <td class="px-6 py-4 text-gray-600">

                                        <?php

                                        if (!empty($cliente["TEL_CLI"])) {

                                            echo htmlspecialchars(
                                                $cliente["TEL_CLI"]
                                            );

                                        } else {

                                            echo '<span class="text-gray-400">
                                                    Não informado
                                                  </span>';

                                        }

                                        ?>

                                    </td>



                                    <!-- TIPO -->

                                    <td class="px-6 py-4 text-center">

                                        <?php if ($cliente["ID_CLI"] == 1): ?>

                                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">
                                                Administrador
                                            </span>

                                        <?php else: ?>

                                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                                Cliente
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                </tr>


                            <?php endwhile; ?>


                        <?php else: ?>


                            <tr>

                                <td
                                    colspan="6"
                                    class="px-6 py-12 text-center"
                                >

                                    <p class="text-lg font-semibold text-gray-500">
                                        Nenhum cliente encontrado.
                                    </p>

                                    <p class="text-sm text-gray-400 mt-1">
                                        Ainda não existem clientes cadastrados.
                                    </p>

                                </td>

                            </tr>


                        <?php endif; ?>


                    </tbody>

                </table>

            </div>

        </div>

    </main>


</body>

</html>