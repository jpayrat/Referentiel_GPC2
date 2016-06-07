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

    public static function getDB(){
        if (self::$database === null){
            self::$database = new Database(self::DB_NAME, self::DB_USER, self::DB_PASS, self::DB_HOST);
        }

        return self::$database;
    }
}