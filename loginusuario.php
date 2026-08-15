<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Rei do Açaí</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-purple-700 min-h-screen flex items-center justify-center">

    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-8">

        <!-- Título -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-purple-700">
                REI DO AÇAÍ
            </h1>

            <p class="text-gray-500 mt-2">
                Entre na sua conta
            </p>
        </div>

        <!-- Formulário -->
        <form action="processa/processa_login.php" method="POST">

            <!-- Usuário -->
            <div>
                <label
                    for="usuario"
                    class="block text-sm font-semibold text-gray-700 mb-1">
                    Nome de usuário
                </label>

                <input
                    type="text"
                    id="usuario"
                    name="usuario"
                    required
                    autocomplete="username"
                    placeholder="Digite seu usuário"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3
                           focus:outline-none focus:ring-2 focus:ring-purple-600">
            </div>

            <!-- Senha -->
            <div>
                <label
                    for="senha"
                    class="block text-sm font-semibold text-gray-700 mb-1">
                    Senha
                </label>

                <input
                    type="password"
                    id="senha"
                    name="senha"
                    required
                    autocomplete="current-password"
                    placeholder="Digite sua senha"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3
                           focus:outline-none focus:ring-2 focus:ring-purple-600">
            </div>

            <!-- Botão -->
            <button
                type="submit"
                class="w-full bg-purple-700 hover:bg-purple-800
                       text-white font-bold py-3 rounded-lg
                       transition duration-300">
                Entrar
            </button>

        </form>

        <!-- Cadastro -->
        <p class="text-center text-sm text-gray-600 mt-6">
            Ainda não possui uma conta?

            <a
                href="cadastro.php"
                class="text-purple-700 font-semibold hover:underline">
                Criar conta
            </a>
        </p>

    </div>

</body>
</html>