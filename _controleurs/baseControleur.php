<?php

namespace RefGPC\_controleurs;


/**
 * Description of baseControleur
 *
 * @author Marc
 */
class baseControleur {
    //put your code here
    protected $d = array(); // tableau collectant les données
    
    // accès privé, modifiable que dans baseControleur
    private $base; // MP ou LR
    private $codeBase; // T1 ou K2

    public function __construct($selectBase) {
        $this->base = $selectBase;
        $this->codeBase =  $selectBase == 'LR'? 'K2' : 'T1';  
        $this->barreHaut();
    }

    protected function barreHaut() {
        $this->d['haut']['lienHorizLR'] = WEBPATH.'LR/ilot';
        $this->d['haut']['lienHorizMP'] = WEBPATH.'MP/ilot';
        $this->d['haut']['lienAdmin'] = WEBPATH.'AD/admin';

        $this->d['corps']['codeBase'] = $this->codeBase;  // K2 ou T1 
        $this->d['corps']['libelleBase'] = $this->libelleBase();

        $this->d['haut']['base'] = $this->base; // ui = MP ou LR
        $this->d['haut']['codeBase'] = $this->d['corps']['codeBase']; // K2 ou T1 , copie dans 'haut' pour initialiser les variables du script jsIlot.js
        $this->d['haut']['libelleBase'] = $this->d['corps']['libelleBase'];

        $this->d['haut']['classCSSLienLR'] = $this->classCSSLienActif('LR');
        $this->d['haut']['classCSSLienMP'] = $this->classCSSLienActif('MP');
        $this->d['haut']['classCSSLienAD'] = $this->classCSSLienActif('AD');
    }
    
    /**
     * Retourne 'actif' si la base est celle de l'instance
     * @param type $base ! 'LR' ou 'MP' ou 'AD'
     * @return String 'actif' ou ''
     */
    protected function classCSSLienActif($base) { return $base == $this->base ?  'actif' : ''; }
    
    /**
     * Libellé de la base associée à la base
     * @return String
     */
    protected function libelleBase() { return $this->base == 'LR' ? 'Languedoc-Roussillon' : 'Midi-Pyrénées';  }

    
    protected function base() { return $this->base; }
    protected function codeBase() { return $this->codeBase; }
    
 }
