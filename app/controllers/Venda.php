<?php 
namespace App\Controllers;
use \App\Db\Database;

class Venda {
    public $id;
    public $data;
    public $cliente;
    public $valor_venda;
    public $valor_imposto;

   /*  public function __construct() {
        $this->id = $id;
        $this->descricao = $descricao;
        $this->quantidade = $quantidade;
        $this->valor = $valor;
        $this->tipo = $tipo;
    } */

    public function cadastrar() {
        //cadastra no banco
        $obDatabase = new Database('vendas');
        $this->id = $obDatabase->insert([
            'valor_venda' => $this->valor_venda,
            'valor_imposto' => $this->valor_imposto,
            'cliente' => $this->cliente,
            'date' => $this->data
        ]);
        return $this->id;

    }

    public static function getVendas() {
        return (new Database('vendas'))->select(null, 'id DESC', null, '*')->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

}