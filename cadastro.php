<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro | Rei do Açaí</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-purple-700 min-h-screen flex items-center justify-center">

    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-8">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-purple-700">REI DO AÇAÍ</h1>
            <p class="text-gray-500 mt-2">Crie sua conta</p>
        </div>

        <form action="processa/processa_cadastro.php" method="POST">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    E-mail
                </label>
                <input
                    type="email"
                    name="email"
                    required
                    placeholder="exemplo@email.com"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-600"
                >
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Nome de usuário
                </label>
                <input
                    type="text"
                    name="usuario"
                    required
                    maxlength="30"
                    placeholder="Seu usuário"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-600"
                >
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Senha
                </label>
                <input
                    type="password"
                    name="senha"
                    required
                    minlength="6"
                    placeholder="••••••••"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-600"
                >
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Confirmar senha
                </label>
                <input
                    type="password"
                    name="confirmar"
                    required
                    minlength="6"
                    placeholder="Repita a senha"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-600"
                >
            </div>

            <button
                type="submit"
                class="w-full bg-purple-700 hover:bg-purple-800 text-white font-bold py-3 rounded-lg transition duration-300"
            >
                Criar conta
            </button>

        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            Já possui uma conta?
            <a href="loginusuario.php" class="text-purple-700 font-semibold hover:underline">
                Entrar
            </a>
        </p>

    </div>

</body>
</html>