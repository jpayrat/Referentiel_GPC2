<?php
namespace RefGPC\_models;

class ModelVue {

    public function afficheHaut($variablesHaut) {
        extract($variablesHaut);
        require(VUES_PATH."haut.php");
    }

    public function afficheMenuLateral($variablesLateral) {
        extract($variablesLateral);
        require(VUES_PATH."menuLateral.php");
    }

    public function afficheCorps($variablesCorps, $vue) {
        extract($variablesCorps);
        require(VUES_PATH.$vue.".php");
    }


    public function afficheBas() {
        require(VUES_PATH."bas.php");
    }
}
