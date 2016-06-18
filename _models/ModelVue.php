<?php
namespace RefGPC\_models;

class ModelVue {

    public function afficheHaut($variablesHaut, $js) {
        extract($variablesHaut);
        if($js != null) { $jqueryLoader=  '<script src="'.WEBPATH.'js/'.$js.'.js" type="text/javascript"></script>'; }
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
    
    public function afficheResultIlot($dataSelectAll) {
        // traitement des données

        
        require(VUES_PATH."resultIlot.php");
    }
}
