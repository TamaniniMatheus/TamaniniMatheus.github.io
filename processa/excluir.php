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
    header("Location: ../admin/produtos.php?erro=produtoinvalido");
    exit;
}

// Busca a imagem do produto antes de apagar, para remover o arquivo também
$stmt = $conexao->prepare("SELECT IMAGEM FROM PRODUTO WHERE ID_PROD = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$produto = $stmt->get_result()->fetch_assoc();
$stmt->close();

$stmt = $conexao->prepare("DELETE FROM PRODUTO WHERE ID_PROD = ?");
$stmt->bind_param("i", $id);

if (!$stmt->execute()) {

    // Código 1451 = violação de chave estrangeira (produto já usado em algum pedido)
    $erro_fk = $conexao->errno === 1451;

    $stmt->close();
    $conexao->close();

    if ($erro_fk) {
        header("Location: ../admin/produtos.php?erro=produtoemuso");
    } else {
        header("Location: ../admin/produtos.php?erro=exclusao");
    }

    exit;
}

$stmt->close();

if ($produto && !empty($produto["IMAGEM"]) && file_exists("../" . $produto["IMAGEM"])) {
    unlink("../" . $produto["IMAGEM"]);
}

$conexao->close();
header("Location: ../admin/produtos.php?exclusao=sucesso");
exit;