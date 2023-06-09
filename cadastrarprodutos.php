<?php

require __DIR__ . '/vendor/autoload.php';

use \App\Controllers\Produto;
use \App\Controllers\ProdutoTipo;

DEFINE('TITLE', 'Cadastrar Produtos');

if(isset($_POST['descricao'], $_POST['valor'], $_POST['tipo'])) {
    $obProduto = new Produto;
    $obProduto->descricao = $_POST['descricao'];
    $obProduto->valor = $_POST['valor'];
    $obProduto->quantidade = $_POST['quantidade'];
    $obProduto->tipo = $_POST['tipo'];

    $obProduto->cadastrar();
    header('location: produtos.php?status=success');
    exit;
}

if(isset($_GET['tipos'])) {
    $obProdutoTipo = new ProdutoTipo;
    $tipos = $obProdutoTipo->getTipos();
    echo json_encode($tipos);
    exit;
}

// $title = 'Cadastro de produtos';

include __DIR__ .'/includes/header.php';
include __DIR__ .'/includes/form_produtos.php';
include __DIR__ .'/includes/footer.php';
