<?php 
namespace App\Controllers;
use \App\Db\Database;


class ProdutoTipo {
    public $id;
    public $percentual;
    public $tipo;

    /* public function __construct() {
        if($_POST['metodo']){
            //chama a função de acordo com o método
            $this->$_POST['metodo']();
            echo '<pre>'; print_r('teste'); echo '</pre>'; exit;
        }
    } */

    public function cadastrar() {
        //cadastra no banco
        $obDatabase = new Database('produto_tipo');
        $this->id = $obDatabase->insert([
            'percentual_imposto' => $this->percentual,
            'tipo' => $this->tipo
        ]);
        return true;

    }

    public static function getTipos() {
        // return (new Database('produto_tipo'))->select('SELECT * FROM produto_tipo')->fetchAll(\PDO::FETCH_CLASS, self::class);
        return (new Database('produto_tipo'))->select(null, null, null, '*')->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

}