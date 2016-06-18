<?php

namespace RefGPC\_models;

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
        $this->selectTousIlot($param['iloCodeBase']);
        //var_dump($this->selectTousIlot());
        //var_dump($this->values);
    }

    /**
     * mise en forme des données pour la liste de tous les ilots
     * @param type $iloCodeBase
     */
    protected function selectTousIlot($iloCodeBase) {
        $sql = $this->sqlTmIlotsRechTotale($iloCodeBase);
        $this->values['nbIlots'] = RefGPC::getDB()->queryCount($sql);
        $this->values['dataIlot'] = RefGPC::getDB()->queryAll($sql);

        // charge la liste des sites
        $arrListeZone = $this->createListeZone();
        // calcul de la liste de sites
        foreach ($this->values['dataIlot'] as $k => $row) {
            if (isset($arrListeZone[$row['siIdSite']])) {
                $this->values['dataIlot'][$k]['Liste_sites'] = $arrListeZone[$row['siIdSite']];
            } else {
                $this->values['dataIlot'][$k]['Liste_sites'] = '';
            }
            //$this->values['dataIlot'][$k]['Liste_sites']  = isset($arrListeZone[$row['siIdSite']]) ? $arrListeZone[$row['siIdSite']] :'';

            // mise en forme des champs
            $this->values['dataIlot'][$k]['iloCodeIlot'] = strtoupper($row['iloCodeIlot']);
            $this->values['dataIlot'][$k]['iloLibelleIlot'] = strtoupper($row['iloLibelleIlot']);
            $this->values['dataIlot'][$k]['iloOptim'] = $row['iloOptim'] == 1 ? 'Oui' : 'Non';
            if ($row['used'] == '') {
                $this->values['dataIlot'][$k]['used'] = ' - ';
            }
            if ($row['coIdCompetence'] == '') {
                $this->values['dataIlot'][$k]['coIdCompetence'] = ' - ';
            }
            if ($row['sedIdServDem'] == '') {
                $this->values['dataIlot'][$k]['sedIdServDem'] = ' - ';
            }
            if ($row['enIdEntreprise'] == '') {
                $this->values['dataIlot'][$k]['enIdEntreprise'] = ' - ';
            }
            if ($row['siIdSite'] == '') {
                $this->values['dataIlot'][$k]['siIdSite'] = ' - ';
            }
            if ($row['dacIdDomAct'] == '') {
                $this->values['dataIlot'][$k]['dacIdDomAct'] = ' - ';
            }
 
 
        }
    }

    /**
     * Cree la liste des zones à partir de la table des sites
     * @return un tableau associatif par libelle de zone
     */
    public function createListeZone() {
        $arrZone = array();
        $sql = "/* liste des sous zones de la zone parent */
                SELECT   t_sites.siIdSite as parentId, t_parentzone.siIdSite as zoneID , S.siLibelleSite as libZone, t_sites.siLibelleSite
                FROM (t_sites
                LEFT JOIN  t_parentzone 
                ON t_parentzone.siIdSite_T_Sites = t_sites.siIdSite)

                LEFT JOIN  t_sites as S
                ON t_parentzone.siIdSite = S.siIdSite

                where CHAR_LENGTH(t_sites.siIdSite) > 0;";
        $values = RefGPC::getDB()->queryAll($sql);
        //var_dump($values);
        foreach ($values as $k => $v) {
            if (isset($arrZone[$v['parentId']])) {
                $arrZone[$v['parentId']] .= $v['libZone'] . '<br />';
            } else {
                $arrZone[$v['parentId']] = '<b>' . $v['siLibelleSite'] . ' :</b><br />';
                $arrZone[$v['parentId']] .= $v['libZone'] . '<br />';
            }
        }
        return $arrZone;
    }

    /**
     * Retourne les données dans un tableau pour la vue.
     * @param type $indexData : indice du tableau, sélection des données
     * @return type array()
     */
    public function getData($indexData) {  return $this->values[$indexData];  }

    // ---- requetes SQL -------------------------
    private function sqlTmIlotsAffUnIlot($iloCodeIlot, $iloCodeBase) {
        return "
		SELECT 
		iloCodeIlot, 
		iloLibelleIlot, 
		iloOptim, 
		iloCodeEtablissement, 
		iloCodeBase, 
		iloInfo, 
		iloInfoAdmin, 
		iloDateCreation, 
		iloDateModif, 
		iloDateSuppression, 
		used, 
		tm_ilots.sedIdServDem, 
		tm_ilots.prsIdProdSav, 
		tm_ilots.dacIdDomAct, 
		tm_ilots.coIdCompetence, 
		tm_ilots.siIdSite, 
		tm_ilots.enIdEntreprise, 
		tm_ilots.fiIdFiltrage, 
		tm_ilots.tiIdTypeIot, 
		tm_ilots.banIdBandeau, 
		
		sedLibelleServDem, 
		prsLibelleProdSav, 
		daLibelleDomAct, 
		daDetailDomAct, 
		coLibelleCompetence, 
		tiLibelleTypeIlot, 
		banLibelleBandeau, 
		fiLibelleFiltrage , 
		enLibelleEntreprise, 
		enZoneETREntreprise, 
		siLibelleSite, 
		siOldIdSide, 
		siOldNameSite, 
		siOldZoneSite, 
		siZoneEtlSite
		
		FROM tm_ilots 
		LEFT JOIN t_servicedemandeur ON tm_ilots.sedIdServDem = t_servicedemandeur.sedIdServDem 
		LEFT JOIN t_prodsav ON tm_ilots.prsIdProdSav = t_prodsav.prsIdProdSav 
		LEFT JOIN t_domaineactivite ON tm_ilots.dacIdDomAct = t_domaineactivite.dacIdDomAct
		LEFT JOIN t_competences ON tm_ilots.coIdCompetence = t_competences.coIdCompetence 
		LEFT JOIN t_typeilot ON tm_ilots.tiIdTypeIot = t_typeilot.tiIdTypeIot 
		LEFT JOIN t_bandeau ON tm_ilots.banIdBandeau = t_bandeau.banIdBandeau 
		LEFT JOIN t_filtrage ON tm_ilots.fiIdFiltrage = t_filtrage.fiIdFiltrage 
		LEFT JOIN t_entreprise ON tm_ilots.enIdEntreprise = t_entreprise.enIdEntreprise 
		LEFT JOIN t_sites ON tm_ilots.siIdSite = t_sites.siIdSite 

		WHERE iloCodeIlot = '" . $iloCodeIlot . "' AND iloCodeBase = '" . $iloCodeBase . "' AND (iloDateSuppression = 0 OR isnull(iloDateSuppression));
	
	";
    }

    // recherche globale lister tous les ilots
    private function sqlTmIlotsRechTotale($iloCodeBase) {
        return "
		SELECT DISTINCT
		iloCodeIlot, 
		iloLibelleIlot, 
		iloOptim, 
		iloInfo, 
		used, 
		tm_ilots.sedIdServDem, 
		tm_ilots.dacIdDomAct, 
		tm_ilots.coIdCompetence, 
		tm_ilots.siIdSite, 
		tm_ilots.enIdEntreprise, 
		tm_ilots.tiIdTypeIot, 
		sedLibelleServDem, 
		daLibelleDomAct, 
		coLibelleCompetence, 
		tiLibelleTypeIlot, 
		enLibelleEntreprise, 
		siLibelleSite
		
		FROM tm_ilots 
		LEFT JOIN t_servicedemandeur ON tm_ilots.sedIdServDem = t_servicedemandeur.sedIdServDem 
		LEFT JOIN t_domaineactivite ON tm_ilots.dacIdDomAct = t_domaineactivite.dacIdDomAct
		LEFT JOIN t_competences ON tm_ilots.coIdCompetence = t_competences.coIdCompetence 
		LEFT JOIN t_typeilot ON tm_ilots.tiIdTypeIot = t_typeilot.tiIdTypeIot 
		LEFT JOIN t_filtrage ON tm_ilots.fiIdFiltrage = t_filtrage.fiIdFiltrage 
		LEFT JOIN t_entreprise ON tm_ilots.enIdEntreprise = t_entreprise.enIdEntreprise 
		LEFT JOIN t_sites ON tm_ilots.siIdSite = t_sites.siIdSite 

		WHERE iloCodeBase = '" . $iloCodeBase . "' 
		ORDER BY `iloCodeIlot`;
	";
    }

}
