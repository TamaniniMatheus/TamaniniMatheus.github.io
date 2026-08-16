<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();

if (!isset($_SESSION["ID_CLI"]) || $_SESSION["ID_CLI"] != 1) {
    header("Location: ../loginusuario.php");
    exit;
}

require_once "../config/conexao.php";

// 1. Pega o ID que veio pela URL (ex: editar_produto.php?id=4)
$id = $_GET["id"] ?? "";

// 2. Se não for um número, nem adianta continuar
if (!is_numeric($id)) {
    header("Location: produtos.php");
    exit;
}

// 3. Busca o produto no banco usando prepared statement (mesma lógica de segurança do cadastro)
$stmt = $conexao->prepare("SELECT ID_PROD, NOME_PROD, TIPO_PROD, VALOR_PROD, ESTOQUE, IMAGEM FROM PRODUTO WHERE ID_PROD = ?");
$stmt->bind_param("i", $id);   // "i" = integer, porque ID_PROD é INT
$stmt->execute();
$resultado = $stmt->get_result();
$produto = $resultado->fetch_assoc();  // pega os dados como array associativo
$stmt->close();

// 4. Se não encontrou nenhum produto com esse ID, volta pra lista
if (!$produto) {
    header("Location: produtos.php");
    exit;
}
?>