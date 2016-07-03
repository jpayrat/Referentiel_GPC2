<?php

namespace RefGPC\_systemClass;

class RefGPC
{
    private static $database;
    
    public static function getDB(){
        if (self::$database === null){
            $connexion = null;
            if (isset($_SESSION['connexion'])) {
                $connexion = $_SESSION['connexion'];
            }
            else {
                //echo __CLASS__."::".__METHOD__." : Relecture !! ";
                $filejson = file_get_contents(PATH.'conf/connexion.json');
                //var_dump($filejson);
                 $connexion = json_decode($filejson, true);
                 $_SESSION['connexion'] = $connexion;
            }
            //var_dump($connexion);
            self::$database = new Database( $connexion[SELECT_DB]['db_name'],
                                            $connexion[SELECT_DB]['db_user'],
                                            $connexion[SELECT_DB]['db_pass'],
                                            $connexion[SELECT_DB]['db_host']
                                            );
        }
        return self::$database;
    }
    
    public static function clearConnexion() {
        unset($_SESSION['connexion']); 
    }
}