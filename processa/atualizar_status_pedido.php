<?php

session_start();

if (!isset($_SESSION["ID_CLI"]) || $_SESSION["ID_CLI"] != 1) {
    header("Location: ../loginusuario.php");
    exit;
}

require_once "../config/conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../admin/pedidos.php");
    exit;
}

$id_ped = $_POST["id_ped"] ?? "";
$status_ped = trim($_POST["status_ped"] ?? "");

$status_disponiveis = [
    "Recebido",
    "Em preparo",
    "Saiu para entrega",
    "Entregue",
    "Cancelado"
];

if (!filter_var($id_ped, FILTER_VALIDATE_INT)) {
    header("Location: ../admin/pedidos.php?erro=pedidoinvalido");
    exit;
}

if (!in_array($status_ped, $status_disponiveis, true)) {
    header("Location: ../admin/pedidos.php?erro=statusinvalido");
    exit;
}

$stmt = $conexao->prepare("
    UPDATE PEDIDO
    SET STATUS_PED = ?
    WHERE ID_PED = ?
");

if (!$stmt) {
    header("Location: ../admin/pedidos.php?erro=erro");
    exit;
}

$stmt->bind_param("si", $status_ped, $id_ped);

if ($stmt->execute()) {

    $stmt->close();
    $conexao->close();

    header("Location: ../admin/pedidos.php?status=sucesso");
    exit;
}

$stmt->close();
$conexao->close();

header("Location: ../admin/pedidos.php?erro=erro");
exit;