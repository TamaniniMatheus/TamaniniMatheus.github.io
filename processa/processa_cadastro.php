<?php

require_once "../config/conexao.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
header("Location: ../cadastro.php");
    exit;
}

// Recebe os dados do formulário
$email = trim($_POST["email"] ?? "");
$usuario = trim($_POST["usuario"] ?? "");
$senha = $_POST["senha"] ?? "";
$confirmar = $_POST["confirmar"] ?? "";

// Verifica se todos os campos foram preenchidos
if (empty($email) || empty($usuario) || empty($senha) || empty($confirmar)) {
    die("Preencha todos os campos.");
}

// Verifica se as senhas são iguais
if ($senha !== $confirmar) {
    die("As senhas não coincidem.");
}

// Verifica se o e-mail é válido
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Digite um e-mail válido.");
}

// Verifica se o usuário ou e-mail já estão cadastrados
$sql = "SELECT ID_CLI FROM CLIENTE WHERE USUARIO = ? OR EMAIL_CLI = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("ss", $usuario, $email);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    die("O nome de usuário ou e-mail já está cadastrado.");
}

$stmt->close();

// Criptografa a senha
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

// Cadastra o cliente
$sql = "INSERT INTO CLIENTE (EMAIL_CLI, USUARIO, SENHA)
        VALUES (?, ?, ?)";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("sss", $email, $usuario, $senhaHash);
// Executa o cadastro
if ($stmt->execute()) {

    echo "Cadastro realizado com sucesso!";

} else {

    echo "Erro ao realizar o cadastro: " . $stmt->error;

}

$stmt->close();
$conexao->close();

?>