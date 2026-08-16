<?php

session_start();

if (!isset($_SESSION["ID_CLI"]) || $_SESSION["ID_CLI"] != 1) {
    header("Location: ../loginusuario.php");
    exit;
}

require_once "../config/conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../admin/adicionais.php");
    exit;
}

$nome = trim($_POST["nome_adc"] ?? "");
$tipo = trim($_POST["tipo_adc"] ?? "");
$valor = $_POST["valor_adc"] ?? "";
$estoque = $_POST["estoque"] ?? "";

if ($nome === "" || $tipo === "" || $valor === "" || $estoque === "") {
    header("Location: ../admin/cadastro_adicional.php?erro=preenchimento");
    exit;
}

if (!is_numeric($valor) || $valor < 0 || !is_numeric($estoque) || $estoque < 0) {
    header("Location: ../admin/cadastro_adicional.php?erro=valor");
    exit;
}

$pasta_imagem = "../imagem/";
if (!is_dir($pasta_imagem)) mkdir($pasta_imagem, 0755, true);

$nome_imagem = "";

if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] !== UPLOAD_ERR_NO_FILE) {

    if ($_FILES["imagem"]["error"] !== UPLOAD_ERR_OK) {
        header("Location: ../admin/cadastro_adicional.php?erro=imagem");
        exit;
    }

    $extensoes_permitidas = ["jpg", "jpeg", "png", "webp"];
    $extensao = strtolower(pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION));

    if (!in_array($extensao, $extensoes_permitidas)) {
        header("Location: ../admin/cadastro_adicional.php?erro=formato");
        exit;
    }

    if (getimagesize($_FILES["imagem"]["tmp_name"]) === false) {
        header("Location: ../admin/cadastro_adicional.php?erro=imagem");
        exit;
    }

    $nome_arquivo = uniqid("adicional_", true) . "." . $extensao;
    $caminho_imagem = $pasta_imagem . $nome_arquivo;

    if (!move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminho_imagem)) {
        header("Location: ../admin/cadastro_adicional.php?erro=upload");
        exit;
    }

    $nome_imagem = "imagem/" . $nome_arquivo;
}

$sql = "INSERT INTO ADICIONAL (NOME_ADC, TIPO_ADC, VALOR_ADC, ESTOQUE, IMAGEM) VALUES (?, ?, ?, ?, ?)";
$stmt = $conexao->prepare($sql);

if (!$stmt) {
    header("Location: ../admin/cadastro_adicional.php?erro=banco");
    exit;
}

$stmt->bind_param("ssdis", $nome, $tipo, $valor, $estoque, $nome_imagem);

if ($stmt->execute()) {
    $stmt->close();
    $conexao->close();
    header("Location: ../admin/adicionais.php?cadastro=sucesso");
    exit;
}

$stmt->close();
$conexao->close();
header("Location: ../admin/cadastro_adicional.php?erro=banco");
exit;