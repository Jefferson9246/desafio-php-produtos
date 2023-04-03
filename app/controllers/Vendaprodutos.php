<?php 
namespace App\Controllers;
use \App\Db\Database;

class VendaProdutos {
    public $id;
    public $produto_id;
    public $venda_id;
    public $qtd_produto;
    public $valor_imposto;
    public $total_item;

   /*  public function __construct() {
        $this->id = $id;
        $this->descricao = $descricao;
        $this->quantidade = $quantidade;
        $this->valor = $valor;
        $this->tipo = $tipo;
    } */

    public function cadastrar() {
        //cadastra no banco
        $obDatabase = new Database('venda_produtos');
        $this->id = $obDatabase->insert([
            'venda_id' => $this->venda_id,
            'produto_id' => $this->produto_id,
            'qtd_produto' => $this->qtd_produto,
            'valor_imposto' => $this->valor_imposto,
            'total_item' => $this->total_item
        ]);
        return true;

    }

    public static function getVendaProdutos() {
        return (new Database('venda_produtos'))->select(null, 'id DESC', null, '*')->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

}