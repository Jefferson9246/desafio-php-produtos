<?php

require __DIR__ . '/vendor/autoload.php';


use \App\Controllers\Produto;


$produtos = Produto::getProdutosWithTipo();

define('TITLE', 'Produtos Cadastrados');


include __DIR__ .'/includes/header.php';
include __DIR__ .'/includes/lista_produtos.php';
include __DIR__ .'/includes/footer.php';