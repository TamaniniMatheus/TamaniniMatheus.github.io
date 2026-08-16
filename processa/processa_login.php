<?php

session_start();

require_once "../config/conexao.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
header("Location: ../admin/index.php");
    exit;
}

// Recebe os dados
$usuario = trim($_POST["usuario"] ?? "");
$senha = $_POST["senha"] ?? "";

// Verifica se os campos foram preenchidos
if (empty($usuario) || empty($senha)) {
    die("Preencha o usuário e a senha.");
}

// Procura o usuário no banco
$sql = "SELECT ID_CLI, EMAIL_CLI, USUARIO, SENHA
        FROM CLIENTE
        WHERE USUARIO = ?";

$stmt = $conexao->prepare($sql);

if (!$stmt) {
    die("Erro ao preparar a consulta.");
}

$stmt->bind_param("s", $usuario);
$stmt->execute();

$resultado = $stmt->get_result();

// Verifica se encontrou o usuário
if ($resultado->num_rows === 0) {
    $stmt->close();
    $conexao->close();

    die("Usuário ou senha incorretos.");
}

$cliente = $resultado->fetch_assoc();

// Verifica a senha
if (!password_verify($senha, $cliente["SENHA"])) {

    $stmt->close();
    $conexao->close();

    die("Usuário ou senha incorretos.");
}

// Login realizado com sucesso

$_SESSION["ID_CLI"] = $cliente["ID_CLI"];
$_SESSION["EMAIL_CLI"] = $cliente["EMAIL_CLI"];
$_SESSION["USUARIO"] = $cliente["USUARIO"];

// Verifica se é o administrador
if ($cliente["ID_CLI"] == 1) {

    $stmt->close();
    $conexao->close();

  header("Location: ../admin/index.php");
    exit;

}

// Caso seja cliente
$stmt->close();
$conexao->close();

header("Location: ../index.php");
exit;

?>