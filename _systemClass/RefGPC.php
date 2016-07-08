<?php

namespace RefGPC\_systemClass;

class RefGPC
{
    private static $database;
    
    public static function getDB(){
        if (self::$database === null){

            //echo __CLASS__."::".__METHOD__." : Relecture !! ";
            $filejson = file_get_contents(PATH.'conf/connexion.json');
            //var_dump($filejson);
            $connexion = json_decode($filejson, true);
            //var_dump($connexion);
            
            self::$database = new Database( $connexion[SELECT_DB]['db_name'],
                                            $connexion[SELECT_DB]['db_user'],
                                            $connexion[SELECT_DB]['db_pass'],
                                            $connexion[SELECT_DB]['db_host']
                                            );
        }
        return self::$database;
    }
}