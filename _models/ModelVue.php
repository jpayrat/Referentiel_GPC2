<?php
namespace RefGPC\_models;

class ModelVue {

    /**
     * Haut de page.
     * @param type $variablesHaut
     * @param type $js script à ajouter
     */

    public function afficheHaut($variablesHaut, $js, $css) {
        extract($variablesHaut);
        // js de base
        $jqueryLoader[] = '<script src="'. WEBPATH .'js/jquery-1.12.1.min.js" type="text/javascript"></script>'."\n";
        //CSS de base
        $cssLoader[] = '<link rel="stylesheet" type="text/css" href="'.WEBPATH.'css/style.css" />';
        // js supplementaires
        if($js != null) { $jqueryLoader[] = '<script src="'.WEBPATH.'js/'.$js.'.js" type="text/javascript"></script>'."\n"; }
        //CSS supplémentaire
        if($css != null) { $cssLoader[] = '<link rel="stylesheet" type="text/css" href="'.WEBPATH.'css/'.$css.'.css" />'."\n"; }
        require(VUES_PATH."haut.php");
    }

    public function afficheMsg($variablesCorps, $vue) { extract($variablesCorps); require(VUES_PATH.$vue.".php"); }

    public function afficheMenuLateral($variablesLateral) {
        extract($variablesLateral);
        require(VUES_PATH."menuLateral.php");
    }
    public function afficheMenuLateralAdmin() {
        require(VUES_PATH."menuLateralAdmin.php");
    }

    public function afficheBas() {
        require(VUES_PATH."bas.php");
    }


    /*** Vue des Ilots ***/
    public function afficheIlotCorps($variablesCorps, $vue) { extract($variablesCorps); require(VUES_PATH.'ilot/'.$vue.".php"); }
    public function afficheResultIlot($dataSelectAll) { require(VUES_PATH."ilot/resultIlot.php"); }
    public function afficheDetailIlot($dataSelectOne) { require(VUES_PATH . "ilot/resultIlotSelectOne.php"); }


    /*** Vue des Centres ***/
    public function afficheCentreCorps($variablesCorps, $vue) { extract($variablesCorps); require(VUES_PATH.'centre/'.$vue.".php"); }
    public function afficheResultCentre($dataSelectAll) { require(VUES_PATH."centre/resultCentre.php"); }
    public function afficheDetailCentre($dataSelectOne) { require(VUES_PATH . "centre/resultCentreSelectOne.php"); }

    /*** Vue Admin ***/
    public function afficheAdminCorps($variablesCorps, $vue) { extract($variablesCorps); require(VUES_PATH.'admin/'.$vue.".php"); }
    public function afficheDetailIlotAdmin($dataSelectOne) { require(VUES_PATH."ilot/resultIlotSelectOneAdmin.php"); }



}
