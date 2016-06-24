<?php

namespace RefGPC\_controleurs\ilot;

use \RefGPC\_models\menuLateral;
use \RefGPC\_models\ilot\modelIlot;
use \RefGPC\_models\ilot\Formulaire;
use \RefGPC\_models\ilot\ModelVue;

use \RefGPC\_systemClass\RefGPC; // RefGPC::getDB()

/**
 * recupère les données pour l'affichage des ilots et les envoie à la vue.
 * Controleur permettant d'afficher la page d'accueil des îlots comprenant :
 * -> La mise en évidence de la base choisie dans le menu horizontal LR ou MP
 * -> Le menu latéral en ayant surligné ilot
 * -> Le titre - agrémenté de LR ou MP selon la base choisie
 * -> Le formulaire de recherche globale
 * -> Le formulaire multi-critères
 * -> Les boutons "Tout lister" et "Réinit Formulaire"
 * -> Eventuellement un historique des modifications
 **/

class ilotControleur {

    // $param LR ou MP
    public function affIndex($params) {

        $d = array(); // tableau collectant les données

        $d['haut']['lienHorizLR'] = WEBPATH.'LR/ilot';
        $d['haut']['lienHorizMP'] = WEBPATH.'MP/ilot';

        $param = is_array($params) ? $params['base'] : $params;
        //echo '('.$param.')';
        $choixBase = new modelIlot($param); //ChoixBase($param);
        $d['corps']['codeBase'] = $choixBase->codeBase();
        $d['corps']['libelleBase'] = $choixBase->libelleBase();
        
        $d['haut']['base'] = $param; // ui = MP ou LR
        $d['haut']['codeBase'] = $d['corps']['codeBase']; // K2 ou T1 , copie dans 'haut' pour initialiser les variables du script jsIlot.js
        $d['haut']['libelleBase'] = $d['corps']['libelleBase'];

        $d['haut']['classCSSLienLR'] = $choixBase->classCSSLien('LR');
        $d['haut']['classCSSLienMP'] = $choixBase->classCSSLien('MP');   
        
        $menuLateral = new menuLateral('ilot');
        $d['lateral']['classLienMenuLateralIlot']   = $menuLateral->classCSSMenuLateralActifIlot();
        $d['lateral']['classLienMenuLateralCentre'] = $menuLateral->classCSSMenuLateralActifCentre();
        $d['lateral']['classLienMenuLateralTech']   = $menuLateral->classCSSMenuLateralActifTech();

        $form = new Formulaire($choixBase->codeBase());
        $d['corps']['inputIlotGlobal'] = $form->input('rechercheIlotGlobal', '30','28');
        $d['corps']['inputIlotTape'] = $form->input('rechercheIlotTape','3','3');
        $d['corps']['selectIlotList'] = $form->select('ilotList');
        $d['corps']['selectTypeIlot'] = $form->select('typeIlot');
        $d['corps']['selectUsed'] = $form->select('used');
        $d['corps']['selectCompetence'] = $form->select('competence');
        $d['corps']['selectServiceCible'] = $form->select('serviceCible');
        $d['corps']['selectEntreprise'] = $form->select('entreprise');
        $d['corps']['selectSiteGeo'] = $form->select('siteGeo');
        $d['corps']['selectDomaineAct'] = $form->select('domaineAct');

        $d['corps']['nbIlot'] = RefGPC::getDB()->queryCount("SELECT iloCodeIlot FROM `tm_ilots` WHERE `iloCodeBase` = '".$choixBase->codeBase()."' ");

        //var_dump($d);
        $vue = new ModelVue($d);

        $vue->afficheHaut($d['haut'], 'jsIlot'); // Le second paramètre = fichier js à inclure
        $vue->afficheMenuLateral($d['lateral']);
        $vue->afficheCorps($d['corps'], 'affIndexIlot');// TODO : je n'arrive pas à automatiser le "affIndex"
        $vue->afficheBas();

    }

    /**
     * Extraction des données ilot en csv.
     * Appelé par le lien de la vue resultilot.php, formé par ilotAjaxControleur
     * @param type $sql
     * @throws \Exception : a supprimmer une fois la vue des erreurs ok
     */
    public function extractCsv() {
       // echo '<br />ilotControleur::extractCsv ';
       // var_dump($sql);
        $m = new \RefGPC\_models\ilot\modelIlot();
        if ($m->createExtractFile() == true) {
            // 2 -  download le fichier
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream'); // type de fichier
            header('Content-Disposition: attachment; filename="extractionIlots.csv"'); // nom du fichier
            //flush();
            readfile(PATH.'temp/extractionIlots.csv'); // Le source du fichier original
            //flush();
            //echo "<p> hello fichier généré.";        
        }
        else {
            throw new \Exception("ilotControleur::extractCsv : erreur de creation du fichier extraction");
            // TODO : faire une vue pour afficher l'erreur
        }
    }
    
 }
