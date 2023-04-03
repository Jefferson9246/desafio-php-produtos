<?php

require __DIR__ . '/vendor/autoload.php';

use \App\Controllers\Venda;

define('TITLE', 'Vendas');

$vendas = Venda::getVendas();
include __DIR__ .'/includes/header.php';
include __DIR__ .'/includes/lista_vendas.php';
include __DIR__ .'/includes/footer.php';