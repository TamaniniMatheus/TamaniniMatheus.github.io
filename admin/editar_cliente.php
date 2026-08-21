<?php

require_once "../config/conexao.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| Verifica login
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["ID_CLI"])) {
    header("Location: ../loginusuario.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| Somente administrador
|--------------------------------------------------------------------------
*/

if ($_SESSION["ID_CLI"] != 1) {
    header("Location: ../index.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| Verifica se foi informado um ID
|--------------------------------------------------------------------------
*/

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: clientes.php");
    exit;
}

$id = intval($_GET["id"]);


/*
|--------------------------------------------------------------------------
| Busca o cliente
|--------------------------------------------------------------------------
*/

$sql = "SELECT
            ID_CLI,
            NOME_CLI,
            CPF_CLI,
            TEL_CLI,
            EMAIL_CLI,
            USUARIO
        FROM CLIENTE
        WHERE ID_CLI = ?";

$stmt = $conexao->prepare($sql);

if (!$stmt) {
    die("Erro ao preparar consulta: " . $conexao->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    header("Location: clientes.php");
    exit;
}

$cliente = $resultado->fetch_assoc();

$stmt->close();

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Editar Cliente | Rei do Açaí</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-gray-100 min-h-screen">


    <!-- CABEÇALHO -->

    <header class="bg-purple-700 text-white shadow-md">

        <div class="max-w-5xl mx-auto px-6 py-5 flex items-center justify-between">

            <div>

                <h1 class="text-2xl font-bold">
                    Rei do Açaí
                </h1>

                <p class="text-purple-200 text-sm">
                    Gerenciamento de clientes
                </p>

            </div>


            <a
                href="clientes.php"
                class="bg-white text-purple-700 px-4 py-2 rounded-lg font-semibold hover:bg-purple-50 transition"
            >
                Voltar
            </a>

        </div>

    </header>



    <!-- CONTEÚDO -->

    <main class="max-w-5xl mx-auto px-6 py-10">


        <div class="mb-8">

            <h2 class="text-3xl font-bold text-gray-800">
                Editar cliente
            </h2>

            <p class="text-gray-500 mt-1">
                Atualize as informações do cliente abaixo.
            </p>

        </div>



        <!-- FORMULÁRIO -->

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">

            <form
                action="processa_editar_cliente.php"
                method="POST"
                class="space-y-6"
            >

                <!-- ID -->

                <input
                    type="hidden"
                    name="id"
                    value="<?= htmlspecialchars($cliente["ID_CLI"]) ?>"
                >


                <!-- NOME -->

                <div>

                    <label
                        for="nome"
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Nome completo
                    </label>

                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        value="<?= htmlspecialchars($cliente["NOME_CLI"] ?? "") ?>"
                        maxlength="50"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                        placeholder="Digite o nome do cliente"
                    >

                </div>



                <!-- EMAIL -->

                <div>

                    <label
                        for="email"
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        E-mail
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?= htmlspecialchars($cliente["EMAIL_CLI"] ?? "") ?>"
                        maxlength="100"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                        placeholder="exemplo@email.com"
                    >

                </div>



                <!-- USUÁRIO -->

                <div>

                    <label
                        for="usuario"
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Nome de usuário
                    </label>

                    <input
                        type="text"
                        id="usuario"
                        name="usuario"
                        value="<?= htmlspecialchars($cliente["USUARIO"] ?? "") ?>"
                        maxlength="30"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                        placeholder="Nome de usuário"
                    >

                </div>



                <!-- CPF E TELEFONE -->

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                    <div>

                        <label
                            for="cpf"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            CPF
                        </label>

                        <input
                            type="text"
                            id="cpf"
                            name="cpf"
                            value="<?= htmlspecialchars($cliente["CPF_CLI"] ?? "") ?>"
                            maxlength="14"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                            placeholder="000.000.000-00"
                        >

                    </div>



                    <div>

                        <label
                            for="telefone"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            Telefone
                        </label>

                        <input
                            type="text"
                            id="telefone"
                            name="telefone"
                            value="<?= htmlspecialchars($cliente["TEL_CLI"] ?? "") ?>"
                            maxlength="15"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                            placeholder="(00) 00000-0000"
                        >

                    </div>

                </div>



                <!-- AVISO -->

                <div class="bg-purple-50 border border-purple-100 rounded-xl p-4">

                    <p class="text-sm text-purple-700">

                        <strong>Senha:</strong>
                        a senha atual não será alterada nesta tela.

                    </p>

                    <p class="text-xs text-purple-600 mt-1">

                        Caso seja necessário alterar a senha,
                        criaremos uma função específica posteriormente.

                    </p>

                </div>



                <!-- BOTÕES -->

                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4">


                    <a
                        href="clientes.php"
                        class="px-6 py-3 text-center bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition"
                    >
                        Cancelar
                    </a>


                    <button
                        type="submit"
                        class="px-6 py-3 bg-purple-600 text-white rounded-xl font-semibold hover:bg-purple-700 transition"
                    >
                        Salvar alterações
                    </button>


                </div>

            </form>

        </div>

    </main>


</body>

</html>