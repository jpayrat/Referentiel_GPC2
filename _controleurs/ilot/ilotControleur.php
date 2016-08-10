<?php

namespace RefGPC\_controleurs\ilot;

use \RefGPC\_controleurs\baseControleur;

use \RefGPC\_models\Formulaire;
use \RefGPC\_models\ModelVue;
use \RefGPC\_models\MenuLateral;
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

class ilotControleur extends baseControleur{

    public function __construct($base, $categorie) {
        parent::__construct($base, $categorie);
    }
    
    // $param LR ou MP
    public function affIndex($params) {

        //echo '$codeBase('.$this->codeBase.')';
        $menuLateral = new menuLateral('ilot');
        $this->d['lateral']['classLienMenuLateralIlot']   = $menuLateral->classCSSMenuLateralActifIlot();
        $this->d['lateral']['classLienMenuLateralCentre'] = $menuLateral->classCSSMenuLateralActifCentre();
        $this->d['lateral']['classLienMenuLateralTech']   = $menuLateral->classCSSMenuLateralActifTech();
        $this->d['lateral']['base'] = $this->base;

        $form = new Formulaire($this->codeBase()); // choixBase->codeBase());
        $this->d['corps']['inputIlotGlobal'] = $form->input('rechercheIlotGlobal', '30','28');
        $this->d['corps']['inputIlotTape'] = $form->input('rechercheIlotTape','3','3');
        $this->d['corps']['selectIlotList'] = $form->select('ilotList');
        $this->d['corps']['selectTypeIlot'] = $form->select('typeIlot');
        $this->d['corps']['selectUsed'] = $form->select('used');
        $this->d['corps']['selectCompetence'] = $form->select('competence');
        $this->d['corps']['selectServiceCible'] = $form->select('serviceCible');
        $this->d['corps']['selectEntreprise'] = $form->select('entreprise');
        $this->d['corps']['selectSiteGeo'] = $form->select('siteGeo');
        $this->d['corps']['selectDomaineAct'] = $form->select('domaineAct');

        $this->d['corps']['nbIlot'] = RefGPC::getDB()->queryCount("SELECT iloCodeIlot FROM `tm_ilots` WHERE `iloCodeBase` = '".$this->codeBase()."' ");
        //var_dump($this->d);
        $vue = new ModelVue($this->d);

        $vue->afficheHaut($this->d['haut'], 'jsIlot', 'ilot'); // Le second paramètre = fichier js à inclure
        $vue->afficheMenuLateral($this->d['lateral']);
        $vue->afficheIlotCorps($this->d['corps'], 'affIndexIlot');// TODO : je n'arrive pas à automatiser le "affIndex"
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
