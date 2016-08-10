<?php

namespace RefGPC\_controleurs\centre;

use RefGPC\_controleurs\baseControleur;
use RefGPC\_models\centre\modelCentre;
use \RefGPC\_models\centre\modelSelectAll;
use \RefGPC\_models\centre\modelSelectAny;
use \RefGPC\_models\centre\modelSelectOne;
use \RefGPC\_models\ModelVue;
use \RefGPC\_models\Formulaire;
/**
 * controleur appelé par jsIlot.js.
 * Affiche la vue des ilots 
 */
class centreAjaxControleur extends baseControleur{

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

        $d = array(); // tableau collectant les données
        // données recupere en parametre
        $d['cenCodeBase']       = $this->codeBase();
        $d['Complement_Titre']  = $this->libelleBase();

        // recuperation données modele select_all
        $modelAll = new modelSelectAll($d);
        $d['nbCentre'] = $modelAll->getData('nbCentre');
        $d['dataCentre'] = $modelAll->getData('dataCentre');

        $i = 0;
        while($i < count($d['dataCentre']))
        {
            $d['dataCentre'][$i]['coordGPS'] = $this->lambertIIExtend($d['dataCentre'][$i]['cenCoordGPSLambert2COX'], $d['dataCentre'][$i]['cenCoordGPSLambert2COY']);
            $i = $i +1;
        }

        // lien pour telechargement
        $d['linkXls'] = WEBPATH.$this->codeBase().'/ilot/extractCsv/'; //.'sql=SELECT * from tm_ilots';
        $d['imgXls']  = WEBPATH.'img/_design/excel.jpg';
        
        $vue = new ModelVue();
        $d['rechercheGlobal']=''; // Initialisation de la variable à vide pour correspondre à selectAny (pour le surlignage des
        $d['centre']=''; //valeur tapées par l'utilisateur - recherche globale et ilot tapé
        $vue->afficheResultCentre($d);
    }

    /**
     * Recherche par critère
     * * @param type $param
     */
    public function selectAny($param) {

        $d = array(); // tableau collectant les données
        // données recupere en parametre
        $d['cenCodeBase']       = $this->codeBase();
        $d['Complement_Titre']  = $this->libelleBase();

        $d['rechercheCentreGlobal'] = $this->getParam($param, 'rechercheCentreGlobal');
        $d['centre'] = $this->getParam($param, 'centre');
        $d['zoneETR'] = $this->getParam($param, 'zoneETR');
        $d['idSiteGPC'] = $this->getParam($param, 'idSiteGPC');
        $d['NRA'] = $this->getParam($param, 'NRA');
        $d['repHab'] = $this->getParam($param, 'repHab');
        $d['zoneBlanche'] = $this->getParam($param, 'zoneBlanche');
        $d['blocageR2'] = $this->getParam($param, 'blocageR2');

        $modelAny = new modelSelectAny($d);
        
        $d['dataCentre'] = $modelAny->getData('dataCentre');
        $d['nbCentre'] = $modelAny->getData('nbCentre');

        $i = 0;
        while($i < count($d['dataCentre']))
        {
            $d['dataCentre'][$i]['coordGPS'] = $this->lambertIIExtend($d['dataCentre'][$i]['cenCoordGPSLambert2COX'], $d['dataCentre'][$i]['cenCoordGPSLambert2COY']);
            $i = $i +1;
        }

        /*// charge la liste des sites
        $modelCentre = new modelcentre();
        $arrListeZone = $modelCentre->createListeZone();
        $d['dataIlot'] = $modelCentre->organizeListZone($d['dataIlot'], $arrListeZone);*/
        
        // lien pour telechargement
        $d['linkXls'] = WEBPATH.$param['base'].'/centre/extractCsv/'; //.'sql=SELECT * from tm_ilots';
        $d['imgXls']  = WEBPATH.'img/_design/excel.jpg';

        $vue = new ModelVue();
        $vue->afficheResultCentre($d);
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




    /* Fonction a appeler pour d'autre format que Lambert2E, pas utile pour le moment.
     * public  function lambertI ($x, $y) {return lambert2gps($x,$y,"LambertI");}
    public function lambertII ($x, $y) {return lambert2gps($x,$y,"LambertII");}
    public function lambertIII ($x, $y) {return lambert2gps($x,$y,"LambertIII");}
    public function lambert93 ($x, $y) {return lambert2gps($x,$y,"Lambert93");}
    public function lamberIV ($x, $y) {return lambert2gps($x,$y,"LamberIV");}*/

    public function lambertIIExtend ($x, $y) {return $this->lambert2gps($x,$y,"LambertIIExtend");}
    protected function lambert2gps($x, $y, $lambert) {
        $lamberts = array(
            "LambertI" => 0,
            "LambertII" => 1,
            "LambertIII" => 2,
            "LamberIV" => 3,
            "LambertIIExtend" => 4,
            "Lambert93" => 5
        );
        $index = $lamberts[$lambert];
        $ntabs =  array(0.7604059656, 0.7289686274, 0.6959127966, 0.6712679322, 0.7289686274, 0.7256077650);
        $ctabs =  array(11603796.98, 11745793.39, 11947992.52, 12136281.99, 11745793.39, 11754255.426);
        $Xstabs = array(600000.0, 600000.0, 600000.0, 234.358, 600000.0, 700000.0);
        $Ystabs = array(5657616.674, 6199695.768, 6791905.085, 7239161.542, 8199695.768, 12655612.050);

        $n  = $ntabs [$index];
        $c  = $ctabs [$index];            // En mètres
        $Xs = $Xstabs[$index];          // En mètres
        $Ys = $Ystabs[$index];          // En mètres
        $l0 = 0.0;                    //correspond à la longitude en radian de Paris (2°20'14.025" E) par rapport à Greenwich
        $e = 0.08248325676;           //e du NTF (on le change après pour passer en WGS)
        $eps = 0.00001;     // précision

        /***********************************************************
         *  coordonnées dans la projection de Lambert 2 à convertir *
         ************************************************************/
        $X = $x;
        $Y = $y;

        /*
         * Conversion Lambert 2 -> NTF géographique : ALG0004
         */
        $R = Sqrt((($X - $Xs) * ($X - $Xs)) + (($Y - $Ys) * ($Y - $Ys)));
        $g = Atan(($X - $Xs) / ($Ys - $Y));

        $l = $l0 + ($g / $n);
        $L = -(1 / $n) * Log(Abs($R / $c));


        $phi0 = 2 * Atan(Exp($L)) - (pi() / 2.0);
        $phiprec = $phi0;
        $phii = 2 * Atan((Pow(((1 + $e * Sin($phiprec)) / (1 - $e * Sin($phiprec))), $e / 2.0) * Exp($L))) - (pi() / 2.0);

        while (!(Abs($phii - $phiprec) < $eps)) {
            $phiprec = $phii;
            $phii = 2 * Atan((Pow(((1 + $e * Sin($phiprec)) / (1 - $e * Sin($phiprec))), $e / 2.0) * Exp($L))) - (pi() / 2.0);
        }

        $phi = $phii;

        /*
         * Conversion NTF géogra$phique -> NTF cartésien : ALG0009
         */
        $a = 6378249.2;
        $h = 100;         // En mètres

        $N = $a / (Pow((1 - ($e * $e) * (Sin($phi) * Sin($phi))), 0.5));
        $X_cart = ($N + $h) * Cos($phi) * Cos($l);
        $Y_cart = ($N + $h) * Cos($phi) * Sin($l);
        $Z_cart = (($N * (1 - ($e * $e))) + $h) * Sin($phi);

        /*
         * Conversion NTF cartésien -> WGS84 cartésien : ALG0013
         */

        // Il s'agit d'une simple translation
        $XWGS84 = $X_cart - 168;
        $YWGS84 = $Y_cart - 60;
        $ZWGS84 = $Z_cart + 320;

        /*
         * Conversion WGS84 cartésien -> WGS84 géogra$phique : ALG0012
         */

        $l840 = 0.04079234433;    // 0.04079234433 pour passer dans un référentiel par rapport au méridien
        // de Greenwich, sinon mettre 0

        $e = 0.08181919106;              // On change $e pour le mettre dans le système WGS84 au lieu de NTF
        $a = 6378137.0;

        $P = Sqrt(($XWGS84 * $XWGS84) + ($YWGS84 * $YWGS84));

        $l84 = $l840 + Atan($YWGS84 / $XWGS84);

        $phi840 = Atan($ZWGS84 / ($P * (1 - (($a * $e * $e))
                    / Sqrt(($XWGS84 * $XWGS84) + ($YWGS84 * $YWGS84) + ($ZWGS84 * $ZWGS84)))));

        $phi84prec = $phi840;

        $phi84i = Atan(($ZWGS84 / $P) / (1 - (($a * $e * $e * Cos($phi84prec))
                    / ($P * Sqrt(1 - $e * $e * (Sin($phi84prec) * Sin($phi84prec)))))));

        while (!(Abs($phi84i - $phi84prec) < $eps))
        {
            $phi84prec = $phi84i;
            $phi84i = Atan(($ZWGS84 / $P) / (1 - (($a * $e * $e * Cos($phi84prec))
                        / ($P * Sqrt(1 - (($e * $e) * (Sin($phi84prec) * Sin($phi84prec))))))));
        }

        $phi84 = $phi84i;

        return array($phi84 * 180.0 / pi(), $l84 * 180.0 / pi());
    }


    
}
