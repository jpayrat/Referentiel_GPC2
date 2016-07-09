<?php

namespace RefGPC\_controleurs;
use \RefGPC\_models\ilot\ModelVue;
/**
 * Description of adminControleur
 *
 * @author Marc
 */
class adminControleur extends baseControleur{
    
    public function __construct($base) {
        parent::__construct($base);
    }
    
    
    public  function affIndex($params) {
       // var_dump($this->d);
        $vue = new ModelVue($this->d);

        $vue->afficheHaut($this->d['haut'], 'jsIlot'); // Le second paramètre = fichier js à inclure
        $vue->afficheMenuLateral($this->d['lateral']);
        
        //$vue->afficheCorps($this->d['corps'], 'affIndexIlot');//
        
        $vue->afficheBas();
    }
    
}
