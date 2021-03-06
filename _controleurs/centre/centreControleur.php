<?php

namespace RefGPC\_controleurs\centre;

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

class centreControleur extends baseControleur{

    public function __construct($base, $categorie) {
        parent::__construct($base, $categorie);
    }
    
    // $param LR ou MP
    public function affIndex($params) {

        //var_dump($params);

        //echo '$codeBase('.$this->codeBase.')';
        $menuLateral = new menuLateral('centre');
        $this->d['lateral']['classLienMenuLateralIlot']   = $menuLateral->classCSSMenuLateralActifIlot();
        $this->d['lateral']['classLienMenuLateralCentre'] = $menuLateral->classCSSMenuLateralActifCentre();
        $this->d['lateral']['classLienMenuLateralTech']   = $menuLateral->classCSSMenuLateralActifTech();
        $this->d['lateral']['base'] = $this->base;

        $form = new Formulaire($this->codeBase()); // choixBase->codeBase());
        $this->d['corps']['inputCentreGlobal'] = $form->input('rechercheCentreGlobal', '30','28');
        $this->d['corps']['inputCentreTape'] = $form->input('rechercheCentreTape','3','3');
        $this->d['corps']['selectCentreList'] = $form->select('centreList');
        $this->d['corps']['selectZoneETR'] = $form->select('zoneETR');
        $this->d['corps']['selectIdSiteGPC'] = $form->select('idSiteGPC');
        $this->d['corps']['selectNRA'] = $form->select('NRA');
        $this->d['corps']['selectRepHab'] = $form->select('repHab');
        $this->d['corps']['selectZoneBlanche'] = $form->select('zoneBlanche');
        $this->d['corps']['selectBlocageR2'] = $form->select('blocageR2');

        $this->d['corps']['nbCentre'] = RefGPC::getDB()->queryCount("SELECT cenCodeCentre FROM `tm_centres` WHERE `cenCodeBase` = '".$this->codeBase()."' ");
        //var_dump($this->d);
        $vue = new ModelVue($this->d);

        $vue->afficheHaut($this->d['haut'], 'jsCentre', 'centre'); // Le second paramètre = fichier js à inclure // 3eme parametre CSS
        $vue->afficheMenuLateral($this->d['lateral']);
        $vue->afficheCentreCorps($this->d['corps'], 'affIndexCentre');// TODO : je n'arrive pas à automatiser le "affIndex"
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
