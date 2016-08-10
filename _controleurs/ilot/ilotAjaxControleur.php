<?php

namespace RefGPC\_controleurs\ilot;

use RefGPC\_controleurs\baseControleur;
use RefGPC\_models\ilot\modelIlot;
use \RefGPC\_models\ilot\modelSelectAll;
use \RefGPC\_models\ilot\modelSelectAny;
use \RefGPC\_models\ilot\modelSelectOne;
use \RefGPC\_models\ModelVue;
use \RefGPC\_models\Formulaire;
/**
 * controleur appelé par jsIlot.js.
 * Affiche la vue des ilots 
 */
class ilotAjaxControleur extends baseControleur{

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
        $d['imgXls']  = WEBPATH.'img/_design/excel.jpg';
        
        $vue = new ModelVue();
        $d['rechercheGlobal']=''; // Initialisation de la variable à vide pour correspondre à selectAny (pour le surlignage des
        $d['ilot']=''; //valeur tapées par l'utilisateur - recherche globale et ilot tapé
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

        $verifLogin = parent::verifLogin();
        if($verifLogin == false){
            $this->selectOneLogOFF($param);
        }
        else
        { // true
            $this->selectOneLogIN($param);
        }
    }
    public function selectOneLogOFF($param){
        // Non connecté
        $d = array(); // tableau collectant les données

        // données recupere en parametre

        $d['ilot']              = $this->getParam($param, 'ilot');
        $d['iloCodeBase']       = $this->getParam($param, 'iloCodeBase');
        $d['Complement_Titre']  = $this->getParam($param, 'Complement_Titre');

        $modelOne = new modelSelectOne($d);
        $d['dataIlot'] = $modelOne->getData('dataIlot');

        // charge la liste des sites
        $modelIlot = new modelIlot();
        $arrListeZone = $modelIlot->createListeZone();

        $d['dataIlot'] = $modelIlot->organizeListZone($d['dataIlot'], $arrListeZone);

        $d['dataIlot'][0]['iloDateCreation'] = $d['dataIlot'][0]['iloDateCreation'] == 0 ? ' - ' : date('d-m-Y', $d['dataIlot'][0]['iloDateCreation']);
        $d['dataIlot'][0]['iloDateModif'] = $d['dataIlot'][0]['iloDateModif'] == 0 ? ' - ' : date('d-m-Y', $d['dataIlot'][0]['iloDateModif']);

        $vue = new ModelVue();
        $vue->afficheDetailIlot($d);
    }
    public function selectOneLogIN($param){

        echo 'affichage admin';

        $d['ilot']              = $this->getParam($param, 'ilot');
        $d['iloCodeBase']       = $this->getParam($param, 'iloCodeBase');
        $d['Complement_Titre']  = $this->getParam($param, 'Complement_Titre');

        $modelOne = new modelSelectOne($d);
        $d['dataIlot'] = $modelOne->getData('dataIlot');

        // charge la liste des sites
        $modelIlot = new modelIlot();
        $arrListeZone = $modelIlot->createListeZone();

        $d['dataIlot'] = $modelIlot->organizeListZone($d['dataIlot'], $arrListeZone);

        $d['dataIlot'][0]['iloDateCreation'] = $d['dataIlot'][0]['iloDateCreation'] == 0 ? ' - ' : date('d-m-Y', $d['dataIlot'][0]['iloDateCreation']);
        $d['dataIlot'][0]['iloDateModif'] = $d['dataIlot'][0]['iloDateModif'] == 0 ? ' - ' : date('d-m-Y', $d['dataIlot'][0]['iloDateModif']);

        //var_dump($d['dataIlot']);

        $form = new Formulaire($this->codeBase());
        $d['dataIlot'][0]['selectUsed'] = $form->selectAdmin('used', $d['dataIlot'][0]['used']);
        $d['dataIlot'][0]['selectCoIdCompetence'] = $form->selectAdmin('coIdCompetence', $d['dataIlot'][0]['coIdCompetence']);
        $d['dataIlot'][0]['selectSedIdServDem'] = $form->selectAdmin('sedIdServDem', $d['dataIlot'][0]['sedIdServDem']);
        $d['dataIlot'][0]['selectDacIdDomAct'] = $form->selectAdmin('dacIdDomAct', $d['dataIlot'][0]['dacIdDomAct']);
        $d['dataIlot'][0]['selectDaDetailDomAct'] = $form->selectAdmin('daDetailDomAct', $d['dataIlot'][0]['daDetailDomAct']);
        $d['dataIlot'][0]['selectEnIdEntreprise'] = $form->selectAdmin('enIdEntreprise', $d['dataIlot'][0]['enIdEntreprise']);
        $d['dataIlot'][0]['selectPrsIdProdSav'] = $form->selectAdmin('prsIdProdSav', $d['dataIlot'][0]['prsIdProdSav']);
        $d['dataIlot'][0]['selectSiIdSite'] = $form->selectAdmin('siIdSite', $d['dataIlot'][0]['siIdSite']);
        $d['dataIlot'][0]['textareaIloInfo'] = $form->textarea('iloInfo', $d['dataIlot'][0]['iloInfo'], '90', '5', '600');
        $d['dataIlot'][0]['textareaIloInfoAdmin'] = $form->textarea('iloInfoAdmin', $d['dataIlot'][0]['iloInfoAdmin'], '90', '5', '600');


        $vue = new ModelVue();
        $vue->afficheDetailIlotAdmin($d);
        

    }

}
