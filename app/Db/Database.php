<?php 

namespace App\Db;

use \PDO;
use \PDOException;

class Database {

    // propriedades
    private $table;
    private $connection;

    const HOST = 'localhost';
    const NAME = 'produtos';
    const USER = 'postgres';
    const PASS = '102030';

    // construtor
    public function __construct($table = null) {
        $this->table = $table;
        $this->setConnection();
    }

    // método de conexão
    private function setConnection() {
        try {
            $this->connection = new PDO('pgsql:host='.self::HOST.';dbname='.self::NAME, self::USER, self::PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die('ERROR: '.$e->getMessage());
        }
    }

    // método de execução de queries
    public function execute($query, $params = []) {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (\PDOException $e) {
            die('ERROR: '.$e->getMessage());
        }
    }

    // método de inserção
    public function insert($values) {
        // dados da query
        $fields = array_keys($values);
        $binds = array_pad([], count($fields), '?');
        
        // monta a query
        $query = 'INSERT INTO '.$this->table.' ('.implode(',', $fields).') VALUES ('.implode(',', $binds).')';
        // echo '<pre>'; print_r($query); echo '</pre>'; exit;
        
        // executa o insert
        $this->execute($query, array_values($values));

        // retorna o ID inserido
        return $this->connection->lastInsertId();
    }

    //método de consulta
    public function select($where = null, $order = null, $limit = null, $fields = '*') {
        // dados da query
        $where = strlen($where) ? 'WHERE '.$where : '';
        $order = strlen($order) ? 'ORDER BY '.$order : '';
        $limit = strlen($limit) ? 'LIMIT '.$limit : '';

        // monta a query
        $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

        // executa a consulta
        return $this->execute($query);
    }

    

}

?>