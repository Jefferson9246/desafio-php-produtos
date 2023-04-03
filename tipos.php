<?php

require __DIR__ . '/vendor/autoload.php';


use \App\Controllers\ProdutoTipo;


$tipos = ProdutoTipo::getTipos();

define('TITLE', 'Tipos de produtos');

include __DIR__ .'/includes/header.php';
include __DIR__ .'/includes/lista_tipos.php';
include __DIR__ .'/includes/footer.php';