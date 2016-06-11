<?php

namespace RefGPC\_systemClass;

class RefGPC
{
    private static $database;

    private static $connexion = array(
        'Marc' => array(
                            'db_name' => 'root',
                            'db_user' => '',
                            'db_pass' => 'referentiel-gpc',
                            'db_host' => 'localhost'
                            ),
        'Julien' => array(
                            'db_name' => 'referentiel-gpc_pprod_si',
                            'db_user' => 'referenti_si_dbo',
                            'db_pass' => 'PswcS1li',
                            'db_host' => 'localhost'
                            )
    );

    public static function getDB(){
        if (self::$database === null){
            self::$database = new Database( self::$connexion[SELECT_DB]['db_name'],
                                            self::$connexion[SELECT_DB]['db_user'],
                                            self::$connexion[SELECT_DB]['db_pass'],
                                            self::$connexion[SELECT_DB]['db_host']
                                            );
        }
        return self::$database;
    }
}