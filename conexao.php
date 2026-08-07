<?php

$host = "127.0.0.1";
$usuario = "root";
$senha = "";
$banco = "REIDOACAI";

$conexao = new mysqli($host, $usuario, $senha, $banco,3308);

if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}
?>