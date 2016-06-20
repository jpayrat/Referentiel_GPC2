<?php

namespace RefGPC\_controleurs;

use RefGPC\_models\modelSelectAll;
use \RefGPC\_models\ModelVue;
/**
 * controleur appelé par jsIlot.js.
 * Affiche la vue des ilots 
 */
class ilotAjaxControleur {

    /**
     * methode par defaut.
     * Appelée par reinit de jsIlot.js
     */
    public function affIndex() { 
    }
    
    /**
     * Selectionne le modele et redirrige les données dans la vue
     */
    public function select_all($param) {
        //echo '<br /> '.__CLASS__ . '::' . __METHOD__ ;
        //var_dump($param);
        $d = array(); // tableau collectant les données
        // données recupere en parametre
        $d['select_all']        = $this->getParam($param, 'select_all');
        $d['iloCodeBase']       = $this->getParam($param, 'iloCodeBase');
        $d['Complement_Titre']  = $this->getParam($param, 'Complement_Titre');
        //var_dump($d);
        // recuperation données modele select_all
        $model = new modelSelectAll($d);
        //array_merge($d , $model->getData());
        //var_dump($model->getData());          
        $d['dataIlot'] = $model->getData('dataIlot');
        $d['nbIlots'] = $model->getData('nbIlots');
       // var_dump($d);   

        $vue = new ModelVue();
        $vue->afficheResultIlot($d);
    }

    /**
     * Recherche Globale     
     * * @param type $param
     */
    public function selectAny($param) {
        // TODO a implementer
        echo '<hr />'.'TODO : methode à implementer ! <br />';
        var_dump($param);
        
    }
    public function test($param) {
        echo __CLASS__ . '::' . __METHOD__ . ' : yes !';
        var_dump($param);
    }

    
    private function getParam($paramArray, $paramName) { return isset($paramArray[$paramName]) ? $paramArray[$paramName] : ''; }
}
