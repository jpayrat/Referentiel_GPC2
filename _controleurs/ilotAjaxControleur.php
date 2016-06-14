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
     * Selectionne le modele et redirrige les données dans la vue
     */
    public function affIlots($param) {
        //var_dump($param);
        $d = array(); // tableau collectant les données
        // données recupere en parametre
        $d['select_all']        = $this->getParam($param, 'select_all');
        $d['iloCodeBase']       = $this->getParam($param, 'iloCodeBase');
        $d['Complement_Titre']  = $this->getParam($param, 'Complement_Titre');
        $d['ilot']              = $this->getParam($param, 'ilot');
        //var_dump($d);
        // recuperation données modele select_all
        $model = new modelSelectAll($d);
        //array_merge($d , $model->getData());
        //var_dump($model->getData());          
        $d['dataIlot'] = $model->getData();
        //var_dump($d);   

        $vue = new ModelVue();
        $vue->afficheResultIlot($d);
    }

    public function test($param) {
        echo __CLASS__ . '::' . __METHOD__ . ' : yes !';
        var_dump($param);
    }

    
    private function getParam($paramArray, $paramName) { return isset($paramArray[$paramName]) ? $paramArray[$paramName] : ''; }
}
