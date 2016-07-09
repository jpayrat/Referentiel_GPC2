<?php

namespace RefGPC\_controleurs;

use \RefGPC\_models\menuLateral;
use \RefGPC\_models\ilot\modelIlot;
/**
 * Description of baseControleur
 *
 * @author Marc
 */
class baseControleur {
    //put your code here
    var $d = array(); // tableau collectant les données
    var $base; // MP ou LR
    var $codeBase; // T1 ou K2
    var $choixBase;

    public function __construct($selectBase) {
        $this->base = $selectBase == 'LR' ? 'LR' : 'MP';
        //var_dump($this->base);

        $this->choixBase = new modelIlot($this->base); //ChoixBase($param);
        $this->codeBase = $this->choixBase->codeBase();

        $this->barreHaut();
        $this->menuLMateral('ilot');
    }

    protected function barreHaut() {
        $this->d['haut']['lienHorizLR'] = WEBPATH.'LR/ilot';
        $this->d['haut']['lienHorizMP'] = WEBPATH.'MP/ilot';
        $this->d['haut']['lienAdmin'] = WEBPATH.$this->base.'/admin';      
        //$choixBase = new modelIlot($this->base); //ChoixBase($param);
        $this->d['corps']['codeBase'] = $this->choixBase->codeBase();
        $this->d['corps']['libelleBase'] = $this->choixBase->libelleBase();

        $this->d['haut']['base'] = $this->base; // ui = MP ou LR
        $this->d['haut']['codeBase'] = $this->d['corps']['codeBase']; // K2 ou T1 , copie dans 'haut' pour initialiser les variables du script jsIlot.js
        $this->d['haut']['libelleBase'] = $this->d['corps']['libelleBase'];

        $this->d['haut']['classCSSLienLR'] = $this->choixBase ->classCSSLien('LR');
        $this->d['haut']['classCSSLienMP'] = $this->choixBase ->classCSSLien('MP');

    }

    protected function menuLMateral($option = 'ilot') {
        $menuLateral = new menuLateral($option);
        $this->d['lateral']['classLienMenuLateralIlot']   = $menuLateral->classCSSMenuLateralActifIlot();
        $this->d['lateral']['classLienMenuLateralCentre'] = $menuLateral->classCSSMenuLateralActifCentre();
        $this->d['lateral']['classLienMenuLateralTech']   = $menuLateral->classCSSMenuLateralActifTech();
    }

}
