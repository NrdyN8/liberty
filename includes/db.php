<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 4/28/2018
 * Time: 1:05 PM
 */

class DB{
    private $DB_USER='root';
    private $DB_PASSWORD='123456';
    private $DB_HOST='localhost';
    private $DB_NAME='msg_board';
    private $charset = 'utf8mb4';

    protected $pdo;

    public function __construct() {
        $dsn = "mysql:host=$this->DB_HOST;dbname=$this->DB_NAME;charset=$this->charset";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try{
            $this->pdo = new PDO($dsn, $this->DB_USER, $this->DB_PASSWORD, $opt);
        }catch(PDOException $e){
            Routes::error(500, ["message"=>$e->getMessage()]);
        }
    }

    public function select($query, $variables = []){
        return $this->run($query, $variables)["statement"]->fetchAll();
    }

    public function insert($query, $variables){
        return $this->run($query, $variables)["lastInsertID"];
    }

    public function update($query, $variables){
        return $this->run($query, $variables)["lastInsertID"];
    }

    private function run($query, $variables){
        $this->pdo->beginTransaction();
        try{
            $statement = $this->pdo->prepare($query);
            $statement->execute($variables);
            $id = $this->pdo->lastInsertId();
            $this->pdo->commit();
        }catch(Exception $e){
            $this->pdo->rollBack();
            Routes::error(500, ["message"=>$e->getMessage()]);
        }
        return ["statement"=>$statement, "lastInsertID"=>$id];
    }
}