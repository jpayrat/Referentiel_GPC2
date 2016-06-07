<?php

namespace RefGPC\_systemClass;

class Autoloader{

    const RACINE_NAMESPACE = 'RefGPC';

    static function register(){
       spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    static function autoload($className){

        if(strpos($className, self::RACINE_NAMESPACE.'\\') === 0){
            $className = str_replace(self::RACINE_NAMESPACE.'\\', '', $className);
            $className = str_replace('\\', '/', $className);

            require PATH.$className.'.php';
        }
        else {
           $msg =  '<br />Autoloader::autoload : impossible de charger ['.$className.']'; 
            echo $msg;
           // throw new RefGpcException($msg); // A voir pour la suite les exceptions
        }
    }
}
