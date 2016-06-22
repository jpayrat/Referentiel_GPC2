<?php

namespace RefGPC\_models\ilot;

/**
 * choix de la base K2 ou T1
 */
class ChoixBase
{
    protected $ui;
    function __construct($choixUI) {
        //var_dump($choixUI);
        $this->ui = $choixUI;
        //var_dump($this->ui);
    }
    
    public function libelleBase() { return $this->ui == 'LR' ? 'Languedoc-Roussillon' : 'Midi-Pyrénées';  }
    public function codeBase() { return $this->ui == 'LR'? 'K2' : 'T1';  }
    public function classCSSLien($ui) { return $ui == $this->ui ?  'actif' : ''; }

}