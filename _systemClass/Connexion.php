<?php
namespace RefGPC\_systemClass;
/*
 * modele d'utilisateur
 * TODO :
 * Voir si on deplace dans les modeles
 */

/**
 * Description of User
 * Description d'une Connexion et des codes d'accés
 * Interet : avoir plusiers utilisateurs avec des login différents
 * @author Marc
 */
class Connexion {

    private $database;
    
    /**
     * tableau contenant les identifiants de connexions aux base de données
     * 0 :  id des données exemple 'local' ou 'distant'
     * 1 : DB_USER
     * 2 : DB_PASS
     * 3 : DB_NAME
     * 4 : DB_HOST
     * @var type 
     */
    var $dbData = array();

    
    public function __construct() {
        $this->dbData = array();
        $this->database = null;
    }
    
    /**
     * ajoute une connexion a une base de donnée
     * @param type $idName 'local' ou 'distant' ou autre nom pour designer une BD
     * @param type $dbuser
     * @param type $dbpass
     * @param type $baseLogin
     * @param type $host
     */
    public function addDB($idName, $dbuser, $dbpass, $dbname, $dbhost = 'localhost') {
        $this->dbData[$idName]['DB_USER'] = $dbuser;
        $this->dbData[$idName]['DB_PASS'] = $dbpass;
        $this->dbData[$idName]['DB_NAME'] = $dbname;
        $this->dbData[$idName]['DB_HOST'] = $dbhost;
    }
    
    /**
     * Retourne la base de donnée de l'utilisateur
     * exemple $database = $toto->getDB('local');
     * @param type $idName surnom de la connexion a la DB
     * @return type
     */
    public function getDB($idName) {
       if ($this->database === null){
            $this->database = new Database(
                    $this->dbData[$idName]['DB_NAME'], 
                    $this->dbData[$idName]['DB_USER'], 
                    $this->dbData[$idName]['DB_PASS'], 
                    $this->dbData[$idName]['DB_HOST']);
       }
       return $this->database;
    }

}
