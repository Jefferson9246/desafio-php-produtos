<?php

require __DIR__ . '/vendor/autoload.php';

use \App\Controllers\Produto;


define('TITLE', 'Cadastro de Venda');



use \App\Controllers\Venda;
use \App\Controllers\VendaProdutos;

$produtos = Produto::getProdutos();

if(isset($_GET['produto'])){
    $produto = Produto::getProdutosWithTipo($_GET['produto']);
    echo json_encode($produto);
    exit;
}

if(isset($_POST['cliente'])){
    $obVenda = new Venda;
    $obVenda->cliente = $_POST['cliente'];
    $obVenda->valor_venda = $_POST['valor_venda'];
    $obVenda->valor_imposto = $_POST['valor_imposto'];
    $obVenda->data = date('Y-m-d');
    $id_venda = $obVenda->cadastrar();

    $itens = json_decode($_POST['itens']);
    foreach($itens as $produto){
        $obVendaProdutos = new VendaProdutos;
        $obVendaProdutos->venda_id = $id_venda;
        $obVendaProdutos->produto_id = $produto->produto_id;
        $obVendaProdutos->qtd_produto = $produto->quantidade;
        $obVendaProdutos->valor_imposto = $produto->imposto;
        $obVendaProdutos->total_item = $produto->total;
        $obVendaProdutos->cadastrar();
    }
    echo json_encode(['status' => 'success']);
    exit;
}


include __DIR__ .'/includes/header.php';
include __DIR__ .'/includes/form_venda.php';
include __DIR__ .'/includes/footer.php';
