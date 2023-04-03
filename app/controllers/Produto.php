<?php 
namespace App\Controllers;
use \App\Db\Database;

class Produto {
    public $id;
    public $descricao;
    public $quantidade;
    public $valor;
    public $tipo;

   /*  public function __construct() {
        $this->id = $id;
        $this->descricao = $descricao;
        $this->quantidade = $quantidade;
        $this->valor = $valor;
        $this->tipo = $tipo;
    } */

    public function cadastrar() {
        //cadastra no banco
        $obDatabase = new Database('produtos');
        $this->id = $obDatabase->insert([
            'descricao' => $this->descricao,
            'quantidade' => $this->quantidade,
            'valor' => $this->valor,
            'produto_tipo_id' => $this->tipo
        ]);
        return true;

    }

    public static function getProdutos() {
        return (new Database('produtos'))->select(null, 'descricao DESC', null, '*')->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    public static function getProduto($id) {
        return (new Database('produtos'))->select('id = '.$id)->fetchObject(self::class);
    }

    public static function getProdutosWithTipo($id = null) {
        $sql = "
            SELECT produtos.*, produto_tipo.*
            FROM produtos
            JOIN produto_tipo ON produtos.produto_tipo_id = produto_tipo.id
            " . ($id ? "WHERE produtos.id = $id" : "") . "
            ORDER BY produtos.descricao DESC
            
        ";
        return (new Database('produtos'))->execute($sql)->fetchAll(\PDO::FETCH_CLASS, self::class);
    }



}