<?php

namespace RefGPC\_controleurs\ilot;

use RefGPC\_models\ilot\modelIlot;
use \RefGPC\_models\ilot\modelSelectAll;
use \RefGPC\_models\ilot\modelSelectAny;
use \RefGPC\_models\ilot\modelSelectOne;
use \RefGPC\_models\ilot\ModelVue;
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

    private function getParam($paramArray, $paramName) { return isset($paramArray[$paramName]) ? $paramArray[$paramName] : ''; }

    /**
     * Recherche Globale
     * * @param type $param
     */
    public function select_all($param) {
        //echo '<br /> '.__CLASS__ . '::' . __METHOD__ ;
        //var_dump($param);
        $d = array(); // tableau collectant les données
        // données recupere en parametre
        //$d['select_all']        = $this->getParam($param, 'select_all');
        $d['iloCodeBase']       = $this->getParam($param, 'iloCodeBase');
        $d['Complement_Titre']  = $this->getParam($param, 'Complement_Titre');

        // recuperation données modele select_all
        $modelAll = new modelSelectAll($d);

        $d['dataIlot'] = $modelAll->getData('dataIlot');
        $d['nbIlots'] = $modelAll->getData('nbIlots');

        // charge la liste des sites
        $modelIlot = new modelIlot();
        $arrListeZone = $modelIlot->createListeZone();
        $d['dataIlot'] = $modelIlot->organizeListZone($d['dataIlot'], $arrListeZone);

        // lien pour telechargement
        $d['linkXls'] = WEBPATH.$param['base'].'/ilot/extractCsv/'; //.'sql=SELECT * from tm_ilots';
        $d['imgXls']  = WEBPATH.'img/excel.jpg';
        
        $vue = new ModelVue();
        $vue->afficheResultIlot($d);
    }

    /**
     * Recherche par critère
     * * @param type $param
     */
    public function selectAny($param) {

        $d = array(); // tableau collectant les données
        // données recupere en parametre

        $d['rechercheGlobal']       = $this->getParam($param, 'rechercheGlobal');
        $d['optim']       = $this->getParam($param, 'optim');
        $d['ilot']       = $this->getParam($param, 'ilot');
        $d['typeIlot']       = $this->getParam($param, 'typeIlot');
        $d['used']       = $this->getParam($param, 'used');
        $d['competence']       = $this->getParam($param, 'competence');
        $d['serviceCible']       = $this->getParam($param, 'serviceCible');
        $d['entreprise']       = $this->getParam($param, 'entreprise');
        $d['siteGeo']       = $this->getParam($param, 'siteGeo');
        $d['domaineAct']       = $this->getParam($param, 'domaineAct');
        $d['iloCodeBase']       = $this->getParam($param, 'iloCodeBase');
        $d['Complement_Titre']  = $this->getParam($param, 'Complement_Titre');

        $modelAny = new modelSelectAny($d);
        
        $d['dataIlot'] = $modelAny->getData('dataIlot');
        $d['nbIlots'] = $modelAny->getData('nbIlots');

        // charge la liste des sites
        $modelIlot = new modelIlot();
        $arrListeZone = $modelIlot->createListeZone();
        $d['dataIlot'] = $modelIlot->organizeListZone($d['dataIlot'], $arrListeZone);
        
        // lien pour telechargement
        $d['linkXls'] = WEBPATH.$param['base'].'/ilot/extractCsv/'; //.'sql=SELECT * from tm_ilots';
        $d['imgXls']  = WEBPATH.'img/excel.jpg';

        $vue = new ModelVue();
        $vue->afficheResultIlot($d);
    }


    public function select_one($param) {

        //if connecté

        $d = array(); // tableau collectant les données

        // données recupere en parametre
        $d['ilot']       = $this->getParam($param, 'ilot');
        $d['iloCodeBase']       = $this->getParam($param, 'iloCodeBase');
        $d['Complement_Titre']  = $this->getParam($param, 'Complement_Titre');

        $modelOne = new modelSelectOne($d);

        $d['dataIlot'] = $modelOne->getData('dataIlot');

        // charge la liste des sites
        $modelIlot = new modelIlot();
        $arrListeZone = $modelIlot->createListeZone();
        $d['dataIlot'] = $modelIlot->organizeListZone($d['dataIlot'], $arrListeZone);

        //if ($d['dataIlot'][0]['iloDateCreation'] == 0) { $d['dataIlot'][0]['iloDateCreation'] = ' - '; } else { $d['dataIlot'][0]['iloDateCreation'] = date('d-m-Y', $row['iloDateCreation']); }
        //if ($d['dataIlot'][0]['iloDateModif'] == 0) { $d['dataIlot'][0]['iloDateModif'] = ' - '; } else { $d['dataIlot'][0]['iloDateModif'] = date('d-m-Y', $d['dataIlot'][0]['iloDateModif']); }
        $d['dataIlot'][0]['iloDateCreation'] = $d['dataIlot'][0]['iloDateCreation'] == 0 ? ' - ' : date('d-m-Y', $d['dataIlot'][0]['iloDateCreation']);
        $d['dataIlot'][0]['iloDateModif'] = $d['dataIlot'][0]['iloDateModif'] == 0 ? ' - ' : date('d-m-Y', $d['dataIlot'][0]['iloDateModif']);
        //var_dump($d['dataIlot']);
        //print_r($d['dataIlot']);

        $vue = new ModelVue();
        $vue->afficheDetailIlot($d);
    }

}
