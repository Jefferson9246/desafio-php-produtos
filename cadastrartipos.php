<?php

require __DIR__ . '/vendor/autoload.php';
$title = 'Cadastro de tipos';



use \App\Controllers\ProdutoTipo;

if(isset($_POST['descricao'])) {
    $obProdutoTipo = new ProdutoTipo;
    $obProdutoTipo->tipo = $_POST['descricao'];
    $obProdutoTipo->percentual = $_POST['percentual'];
    $obProdutoTipo->cadastrar();
    header('location: tipos.php?status=success');
    exit;
}

include __DIR__ .'/includes/header.php';
include __DIR__ .'/includes/form_tipos.php';
include __DIR__ .'/includes/footer.php';
