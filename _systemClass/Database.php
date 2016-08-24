<?php

namespace RefGPC\_systemClass;

use \PDO;
class Database{

    private $db_name;
    private $db_user;
    private $db_pass;
    private $db_host;
    private $pdo;

    public function __construct($db_name, $db_user, $db_pass, $db_host)
    {
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
        $this->pdo = NULL;
    }
    
    private function getPDO(){
        if($this->pdo === NULL) {
            $pdo = new PDO('mysql:dbname='.$this->db_name.';host='.$this->db_host, $this->db_user, $this->db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec('SET NAMES utf8');
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }

    public function queryTransaction(){
        $this->getPDO()->beginTransaction();
    }
    public function queryCommit(){
        $this->getPDO()->commit();
    }
    public function queryRollBack(){
        $this->getPDO()->rollBack();
    }

    /*
try{
RefGPC::getDB()->beginTransaction();
RefGPC::getDB()->queryExec($sql);
RefGPC::getDB()->commit();
}
catch (Exception $e) {
    RefGPC::getDB()->rollBack();
    echo "Failed: " . $e->getMessage();
}*/
    public function queryCount($statement){
        $req = $this->getPDO()->query($statement);
        $res = $req->rowCount();
        return $res;
    }

    public function queryExec($statement){
        $res = $this->getPDO()->exec($statement);
        return $res;
    }

    public function queryOne($statement){
        $req = $this->getPDO()->query($statement);
        $res = $req->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    public function queryAll($statement){
        $req = $this->getPDO()->query($statement);
        $res = $req->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
}