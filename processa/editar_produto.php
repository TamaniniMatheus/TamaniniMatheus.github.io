<?php

session_start();

if (!isset($_SESSION["ID_CLI"]) || $_SESSION["ID_CLI"] != 1) {
    header("Location: ../loginusuario.php");
    exit;
}

require_once "../config/conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../admin/produtos.php");
    exit;
}

$id = $_POST["id_prod"] ?? "";

if (!is_numeric($id)) {
    header("Location: ../admin/produtos.php");
    exit;
}

$nome = trim($_POST["nome_prod"] ?? "");
$tipo = trim($_POST["tipo_prod"] ?? "");
$valor = $_POST["valor_prod"] ?? "";
$estoque = $_POST["estoque"] ?? "";

if ($nome === "" || $tipo === "" || $valor === "" || $estoque === "") {
    header("Location: ../admin/editar_produto.php?id=$id&erro=preenchimento");
    exit;
}

if (!is_numeric($valor) || $valor < 0 || !is_numeric($estoque) || $estoque < 0) {
    header("Location: ../admin/editar_produto.php?id=$id&erro=valor");
    exit;
}

// Busca a imagem atual (para saber qual manter ou apagar depois de trocar)
$stmt = $conexao->prepare("SELECT IMAGEM FROM PRODUTO WHERE ID_PROD = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$produto_atual = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$produto_atual) {
    header("Location: ../admin/produtos.php");
    exit;
}

$nome_imagem = $produto_atual["IMAGEM"];

if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] !== UPLOAD_ERR_NO_FILE) {

    if ($_FILES["imagem"]["error"] !== UPLOAD_ERR_OK) {
        header("Location: ../admin/editar_produto.php?id=$id&erro=imagem");
        exit;
    }

    $extensoes_permitidas = ["jpg", "jpeg", "png", "webp"];
    $extensao = strtolower(pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION));

    if (!in_array($extensao, $extensoes_permitidas)) {
        header("Location: ../admin/editar_produto.php?id=$id&erro=formato");
        exit;
    }

    if (getimagesize($_FILES["imagem"]["tmp_name"]) === false) {
        header("Location: ../admin/editar_produto.php?id=$id&erro=imagem");
        exit;
    }

    $pasta_imagem = "../imagem/";
    if (!is_dir($pasta_imagem)) mkdir($pasta_imagem, 0755, true);

    $nome_arquivo = uniqid("produto_", true) . "." . $extensao;
    $caminho_imagem = $pasta_imagem . $nome_arquivo;

    if (!move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminho_imagem)) {
        header("Location: ../admin/editar_produto.php?id=$id&erro=upload");
        exit;
    }

    // Apaga a imagem antiga do servidor, já que uma nova foi enviada
    if (!empty($produto_atual["IMAGEM"]) && file_exists("../" . $produto_atual["IMAGEM"])) {
        unlink("../" . $produto_atual["IMAGEM"]);
    }

    $nome_imagem = "imagem/" . $nome_arquivo;
}

$sql = "UPDATE PRODUTO SET NOME_PROD = ?, TIPO_PROD = ?, VALOR_PROD = ?, ESTOQUE = ?, IMAGEM = ? WHERE ID_PROD = ?";
$stmt = $conexao->prepare($sql);

if (!$stmt) {
    header("Location: ../admin/editar_produto.php?id=$id&erro=banco");
    exit;
}

$stmt->bind_param("ssdisi", $nome, $tipo, $valor, $estoque, $nome_imagem, $id);

if ($stmt->execute()) {
    $stmt->close();
    $conexao->close();
    header("Location: ../admin/produtos.php?edicao=sucesso");
    exit;
}

$stmt->close();
$conexao->close();
header("Location: ../admin/editar_produto.php?id=$id&erro=banco");
exit;