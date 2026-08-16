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

$id = $_POST["id_adc"] ?? "";

if (!is_numeric($id)) {
    header("Location: ../admin/adicionais.php?erro=adicionalinvalido");
    exit;
}

// Busca a imagem do adicional ANTES de apagar, SEM usar get_result()
$stmt = $conexao->prepare("SELECT IMAGEM FROM ADICIONAL WHERE ID_ADC = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($imagem_adicional);
$stmt->fetch();
$stmt->close();

$stmt = $conexao->prepare("DELETE FROM ADICIONAL WHERE ID_ADC = ?");
$stmt->bind_param("i", $id);

if (!$stmt->execute()) {

    // Código 1451 = violação de chave estrangeira (adicional já usado em algum pedido)
    $erro_fk = $conexao->errno === 1451;

    $stmt->close();
    $conexao->close();

    if ($erro_fk) {
        header("Location: ../admin/adicionais.php?erro=adicionalemuso");
    } else {
        header("Location: ../admin/adicionais.php?erro=exclusao");
    }

    exit;
}

$stmt->close();

if (!empty($imagem_adicional) && file_exists("../" . $imagem_adicional)) {
    unlink("../" . $imagem_adicional);
}

$conexao->close();
header("Location: ../admin/adicionais.php?exclusao=sucesso");
exit;