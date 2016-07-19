<?php
namespace RefGPC\_models\ilot;

class ModelVue {

    /**
     * Haut de page.
     * @param type $variablesHaut
     * @param type $js script à ajouter
     */
    public function afficheHaut($variablesHaut, $js) {
        extract($variablesHaut);
        
        // js de base
        $jqueryLoader[] = '<script src="'. WEBPATH .'js/jquery-1.12.1.min.js" type="text/javascript"></script>'."\n";
        // js supplementaires
        if($js != null) { $jqueryLoader[] = '<script src="'.WEBPATH.'js/'.$js.'.js" type="text/javascript"></script>'."\n";; }
        require(VUES_PATH."haut.php");
    }

    public function afficheMenuLateral($variablesLateral) {
        extract($variablesLateral);
        require(VUES_PATH."menuLateral.php");
    }

    public function afficheCorps($variablesCorps, $vue) {
        extract($variablesCorps);
        require(VUES_PATH.'ilot/'.$vue.".php");
    }

    public function afficheBas() {
        require(VUES_PATH."bas.php");
    }
    
    public function afficheResultIlot($dataSelectAll) {
        // traitement des données
        require(VUES_PATH."ilot/resultIlot.php");
    }

    public function afficheDetailIlot($dataSelectOne) {
        // traitement des données
        require(VUES_PATH."ilot/resultIlotSelectOne.php");
    }
}
