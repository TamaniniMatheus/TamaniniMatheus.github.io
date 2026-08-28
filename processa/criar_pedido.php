<?php

session_start();

require_once "../config/conexao.php";

/*
|--------------------------------------------------------------------------
| VERIFICAR CLIENTE LOGADO
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["ID_CLI"]) || $_SESSION["ID_CLI"] == 1) {
    header("Location: ../loginusuario.php");
    exit;
}

$id_cli = (int) $_SESSION["ID_CLI"];


/*
|--------------------------------------------------------------------------
| VERIFICAR MÉTODO DE PAGAMENTO
|--------------------------------------------------------------------------
*/

$metodo_pag = $_POST["metodo_pag"] ?? "";

$metodos_validos = [
    "Pix",
    "Dinheiro",
    "Cartão"
];

if (!in_array($metodo_pag, $metodos_validos, true)) {
    header("Location: ../cliente/finalizar_pedido.php?erro=pagamento");
    exit;
}


/*
|--------------------------------------------------------------------------
| RECEBER CARRINHO
|--------------------------------------------------------------------------
|
| O carrinho é armazenado no localStorage pelo JavaScript.
| Como o localStorage não é enviado automaticamente ao PHP,
| o finalizar_pedido.js deverá enviar os dados para este arquivo.
|
*/

$carrinho_json = $_POST["carrinho"] ?? "";

if (empty($carrinho_json)) {
    header("Location: ../cliente/carrinho.php?erro=vazio");
    exit;
}

$carrinho = json_decode($carrinho_json, true);

if (!is_array($carrinho) || count($carrinho) === 0) {
    header("Location: ../cliente/carrinho.php?erro=vazio");
    exit;
}


/*
|--------------------------------------------------------------------------
| BUSCAR ENDEREÇO DO CLIENTE
|--------------------------------------------------------------------------
*/

$sql_cliente = "
    SELECT COD_END
    FROM CLIENTE
    WHERE ID_CLI = ?
";

$stmt_cliente = $conexao->prepare($sql_cliente);

if (!$stmt_cliente) {
    die("Erro ao preparar consulta do cliente.");
}

$stmt_cliente->bind_param("i", $id_cli);
$stmt_cliente->execute();

$resultado_cliente = $stmt_cliente->get_result();
$cliente = $resultado_cliente->fetch_assoc();

$stmt_cliente->close();


if (!$cliente || empty($cliente["COD_END"])) {
    header("Location: ../cliente/finalizar_pedido.php?erro=endereco");
    exit;
}

$cod_end = (int) $cliente["COD_END"];


/*
|--------------------------------------------------------------------------
| INICIAR TRANSAÇÃO
|--------------------------------------------------------------------------
*/

$conexao->begin_transaction();

try {

    $valor_total = 0;


/*
|--------------------------------------------------------------------------
| PREPARAR CONSULTA DOS PRODUTOS
|--------------------------------------------------------------------------
*/

    $stmt_produto = $conexao->prepare("
        SELECT
            ID_PROD,
            NOME_PROD,
            VALOR_PROD,
            ESTOQUE
        FROM PRODUTO
        WHERE ID_PROD = ?
    ");

    if (!$stmt_produto) {
        throw new Exception("Erro ao preparar consulta do produto.");
    }


/*
|--------------------------------------------------------------------------
| CALCULAR TOTAL DO PEDIDO
|--------------------------------------------------------------------------
*/

    foreach ($carrinho as $item) {

        if (!isset($item["id"])) {
            throw new Exception("Produto inválido no carrinho.");
        }

        $id_prod = (int) $item["id"];

        $quantidade = isset($item["quantidade"])
            ? (int) $item["quantidade"]
            : 1;

        if ($quantidade <= 0) {
            throw new Exception("Quantidade inválida.");
        }


        $stmt_produto->bind_param("i", $id_prod);
        $stmt_produto->execute();

        $resultado_produto = $stmt_produto->get_result();
        $produto = $resultado_produto->fetch_assoc();


        if (!$produto) {
            throw new Exception("Produto não encontrado.");
        }


        if ($produto["ESTOQUE"] < $quantidade) {
            throw new Exception(
                "Estoque insuficiente para o produto: " .
                $produto["NOME_PROD"]
            );
        }


        /*
        |--------------------------------------------------------------
        | VALOR DO PRODUTO
        |--------------------------------------------------------------
        */

        $valor_produto = (float) $produto["VALOR_PROD"];

        $subtotal_produto = $valor_produto * $quantidade;

        $valor_total += $subtotal_produto;


        /*
        |--------------------------------------------------------------
        | ADICIONAIS
        |--------------------------------------------------------------
        */

        if (isset($item["adicionais"]) && is_array($item["adicionais"])) {

            foreach ($item["adicionais"] as $adicional) {

                $valor_adicional = isset($adicional["valor"])
                    ? (float) $adicional["valor"]
                    : 0;

                $valor_total += $valor_adicional * $quantidade;
            }
        }
    }

    $stmt_produto->close();


/*
|--------------------------------------------------------------------------
| CRIAR PEDIDO
|--------------------------------------------------------------------------
*/

    $stmt_pedido = $conexao->prepare("
        INSERT INTO PEDIDO
        (
            STATUS_PED,
            METODO_PAG,
            VALOR_TOTAL,
            COD_END,
            COD_CLI
        )
        VALUES
        (
            'Recebido',
            ?,
            ?,
            ?,
            ?
        )
    ");

    if (!$stmt_pedido) {
        throw new Exception("Erro ao preparar criação do pedido.");
    }


    $stmt_pedido->bind_param(
        "sdii",
        $metodo_pag,
        $valor_total,
        $cod_end,
        $id_cli
    );


    if (!$stmt_pedido->execute()) {
        throw new Exception("Erro ao criar pedido.");
    }


    $id_ped = $conexao->insert_id;

    $stmt_pedido->close();


/*
|--------------------------------------------------------------------------
| PREPARAR ITEM_PEDIDO
|--------------------------------------------------------------------------
*/

    $stmt_item = $conexao->prepare("
        INSERT INTO ITEM_PEDIDO
        (
            QUANTIDADE,
            SUBTOTAL,
            COD_PED,
            COD_PROD,
            COD_ADC
        )
        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            ?
        )
    ");

    if (!$stmt_item) {
        throw new Exception("Erro ao preparar item do pedido.");
    }


/*
|--------------------------------------------------------------------------
| PREPARAR ATUALIZAÇÃO DO ESTOQUE
|--------------------------------------------------------------------------
*/

    $stmt_estoque = $conexao->prepare("
        UPDATE PRODUTO
        SET ESTOQUE = ESTOQUE - ?
        WHERE ID_PROD = ?
    ");

    if (!$stmt_estoque) {
        throw new Exception("Erro ao preparar atualização do estoque.");
    }


/*
|--------------------------------------------------------------------------
| INSERIR ITENS
|--------------------------------------------------------------------------
*/

    foreach ($carrinho as $item) {

        $id_prod = (int) $item["id"];

        $quantidade = isset($item["quantidade"])
            ? (int) $item["quantidade"]
            : 1;


        /*
        |--------------------------------------------------------------
        | BUSCAR PREÇO NOVAMENTE NO BANCO
        |--------------------------------------------------------------
        */

        $stmt_preco = $conexao->prepare("
            SELECT VALOR_PROD
            FROM PRODUTO
            WHERE ID_PROD = ?
        ");

        $stmt_preco->bind_param("i", $id_prod);
        $stmt_preco->execute();

        $resultado_preco = $stmt_preco->get_result();
        $produto = $resultado_preco->fetch_assoc();

        $stmt_preco->close();


        if (!$produto) {
            throw new Exception("Produto não encontrado.");
        }


        $valor_produto = (float) $produto["VALOR_PROD"];

        $subtotal = $valor_produto * $quantidade;


        /*
        |--------------------------------------------------------------
        | ADICIONAL
        |--------------------------------------------------------------
        |
        | A estrutura atual permite apenas um COD_ADC por ITEM_PEDIDO.
        | Por isso, neste momento armazenamos o primeiro adicional.
        |
        */

        $cod_adc = null;

        if (
            isset($item["adicionais"]) &&
            is_array($item["adicionais"]) &&
            count($item["adicionais"]) > 0
        ) {

            $primeiro_adicional = $item["adicionais"][0];

            if (isset($primeiro_adicional["id"])) {
                $cod_adc = (int) $primeiro_adicional["id"];
            }
        }


        /*
        |--------------------------------------------------------------
        | INSERIR ITEM
        |--------------------------------------------------------------
        */

        $stmt_item->bind_param(
            "idiii",
            $quantidade,
            $subtotal,
            $id_ped,
            $id_prod,
            $cod_adc
        );


        if (!$stmt_item->execute()) {
            throw new Exception("Erro ao inserir item do pedido.");
        }


        /*
        |--------------------------------------------------------------
        | ATUALIZAR ESTOQUE
        |--------------------------------------------------------------
        */

        $stmt_estoque->bind_param(
            "ii",
            $quantidade,
            $id_prod
        );


        if (!$stmt_estoque->execute()) {
            throw new Exception("Erro ao atualizar estoque.");
        }
    }


    $stmt_item->close();
    $stmt_estoque->close();


/*
|--------------------------------------------------------------------------
| CONFIRMAR TRANSAÇÃO
|--------------------------------------------------------------------------
*/

    $conexao->commit();


/*
|--------------------------------------------------------------------------
| PEDIDO CRIADO COM SUCESSO
|--------------------------------------------------------------------------
*/

    header(
        "Location: ../cliente/pedidos.php?status=sucesso&id=" .
        $id_ped
    );

    exit;


} catch (Exception $e) {

    /*
    |--------------------------------------------------------------------------
    | DESFAZER ALTERAÇÕES
    |--------------------------------------------------------------------------
    */

    $conexao->rollback();


    /*
    |--------------------------------------------------------------------------
    | VOLTAR PARA FINALIZAÇÃO
    |--------------------------------------------------------------------------
    */

    header(
        "Location: ../cliente/finalizar_pedido.php?erro=pedido"
    );

    exit;
}