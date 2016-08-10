<?php

namespace RefGPC\_models\centre;

use \RefGPC\_systemClass\RefGPC;

/**
 * liste des données pour l'affichage des ilots
 *
 * @author Marc
 */
class modelSelectAll {

    //put your code here
    protected $values = array();

    public function __construct($param) {
        //var_dump($param);
        $this->selectTousCentre($param['cenCodeBase']);
        //var_dump($this->selectTousIlot());
        //var_dump($this->values);
    }

    /**
     * mise en forme des données pour la liste de tous les ilots
     * @param type $iloCodeBase
     */
    protected function selectTousCentre($cenCodeBase) {
        $sql = $this->sqlTmCentresRechTotale($cenCodeBase);
        $this->values['nbCentre'] = RefGPC::getDB()->queryCount($sql);
        $this->values['dataCentre'] = RefGPC::getDB()->queryAll($sql);

        // sauvegarde SQL pour reutilisation si extraction
        $_SESSION['sql_Csv'] = $sql;
    }

    /**
     * Retourne les données dans un tableau pour la vue.
     * @param type $indexData : indice du tableau, sélection des données
     * @return type array()
     */
    public function getData($indexData) {
        return $this->values[$indexData];
    }

    // recherche globale lister tous les centre
    private function sqlTmCentresRechTotale($cenCodeBase) {
        return "
		SELECT DISTINCT
		cenCodeCentre,
		cenLibelleCentre,
		cenCoordGPSLambert2COX,
		cenCoordGPSLambert2COY,
		tm_centres.siIdSite,
		t_sites.siLibelleSite,
		tm_centres.zeCodeZoneETR,
		t_zoneetr.zeLibelleZoneETR,
		rhIlot,
		cenZoneBlanche,
		cenNRAOkNok,
		cenInfoAdmin
		
		FROM tm_centres
		  LEFT JOIN t_sites ON tm_centres.siIdSite = t_sites.siIdSite
		  LEFT JOIN t_zoneetr ON tm_centres.zeCodeZoneETR = t_zoneetr.zeCodeZoneETR 
		WHERE cenCodeBase = '" . $cenCodeBase . "'
		ORDER BY `cenCodeCentre`;
	";
    }

}
