<?php

namespace RefGPC\_systemClass;

class RefGPC
{
    const DB_NAME = 'referentiel-gpc_pprod_si';
    const DB_USER = 'referenti_si_dbo';
    const DB_PASS = 'PswcS1li';
    const DB_HOST = 'localhost';
/*
    const DB_NAME = 'referentiel-gpc';
    const DB_USER = 'root';
    const DB_PASS = '';
    const DB_HOST = 'localhost';   
 */
    private static $database;
    private static $connexion;

    public static function getDB(){
        if (self::$database === null){
            if (self::$connexion === null) {
                throw new \Exception("Impossible de se connecter à la base avec une connexion inconnue !");
            }
            self::$database = self::$connexion->getDB(SELECT_DB);
        }

        return self::$database;
    }
    
    public static function connect($connexion){ self::$connexion = $connexion; }
}