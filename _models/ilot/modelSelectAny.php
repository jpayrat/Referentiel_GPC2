<?php

namespace RefGPC\_models\ilot;

use \RefGPC\_systemClass\RefGPC;

class modelSelectAny
{
    protected $values = array();

    public function __construct($param) {
        $sql = $this->sqlTmIlotsRech($param);
        $_SESSION['sql_Csv'] = $sql;
        $this->selectAnyIlot($sql);
    }

    public function getData($indexData) {
        return $this->values[$indexData];
    }

    protected function selectAnyIlot($sql){
        $this->values['nbIlots'] = RefGPC::getDB()->queryCount($sql);
        $this->values['dataIlot'] = RefGPC::getDB()->queryAll($sql);
    }

    protected function sqlTmIlotsRech($param)
    {
        $condition = '';

        if($param['typeIlot'] != '***')
        {
            if(!empty($condition)) { $condition .= " AND tm_ilots.tiIdTypeIot = '".$param['typeIlot']."' "; }
            else { $condition .= " tm_ilots.tiIdTypeIot = '".$param['typeIlot']."' "; }
        }
        if($param['used'] != '***')
        {
            if(!empty($condition)) { $condition .= " AND `used` = '".$param['used']."' "; }
            else { $condition .= " `used` = '".$param['used']."' "; }
        }
        if($param['competence'] != '***')
        {
            if(!empty($condition)) { $condition .= " AND tm_ilots.coIdCompetence = '".$param['competence']."' "; }
            else { $condition .= " tm_ilots.coIdCompetence = '".$param['competence']."' "; }
        }
        if($param['serviceCible'] != '***')
        {
            if(!empty($condition)) { $condition .= " AND tm_ilots.sedIdServDem = '".$param['serviceCible']."' "; }
            else { $condition .= " tm_ilots.sedIdServDem = '".$param['serviceCible']."' "; }
        }
        if($param['entreprise'] != '***')
        {
            if(!empty($condition)) { $condition .= " AND tm_ilots.enIdEntreprise = '".$param['entreprise']."' "; }
            else { $condition .= " tm_ilots.enIdEntreprise = '".$param['entreprise']."' "; }
        }
        if($param['siteGeo'] != '***')
        {
            if(!empty($condition)) { $condition .= " AND tm_ilots.siIdSite = '".$param['siteGeo']."' "; }
            else { $condition .= " tm_ilots.siIdSite = '".$param['siteGeo']."' "; }
        }
        if($param['domaineAct'] != '***')
        {
            if(!empty($condition)) { $condition .= " AND tm_ilots.dacIdDomAct = '".$param['domaineAct']."' "; }
            else { $condition .= " tm_ilots.dacIdDomAct = '".$param['domaineAct']."' "; }
        }
        if($param['optim'] != 'tous')
        {
            if(!empty($condition)) { $condition .= " AND `iloOptim` = '".$param['optim']."' "; }
            else { $condition .= " `iloOptim` = '".$param['optim']."' "; }
        }

        // Recherche de l'îlot et gestion de la recherche globale
        if($param['ilot'] != '')
        {
            if(!empty($condition)) { $condition .= " AND `iloCodeIlot` LIKE '%".$param['ilot']."%' "; }
            else { $condition .= " `iloCodeIlot` LIKE '%".$param['ilot']."%' "; }
        }
        if($param['rechercheGlobal'] != '')
        {
            if(!empty($condition)) { $condition .= " AND (tm_ilots.dacIdDomAct LIKE '%".$param['rechercheGlobal']."%' OR tm_ilots.tiIdTypeIot LIKE '%".$param['rechercheGlobal']."%' OR tm_ilots.used LIKE '%".$param['rechercheGlobal']."%' OR tm_ilots.coIdCompetence LIKE '%".$param['rechercheGlobal']."%' OR tm_ilots.sedIdServDem LIKE '%".$param['rechercheGlobal']."%' OR tm_ilots.enIdEntreprise LIKE '%".$param['rechercheGlobal']."%' OR tm_ilots.siIdSite LIKE '%".$param['rechercheGlobal']."%' OR `iloCodeIlot` LIKE '%".$param['rechercheGlobal']."%' OR `iloLibelleIlot` LIKE '%".$param['rechercheGlobal']."%') "; }
            else { $condition .= " (tm_ilots.dacIdDomAct LIKE '%".$param['rechercheGlobal']."%' OR tm_ilots.tiIdTypeIot LIKE '%".$param['rechercheGlobal']."%' OR tm_ilots.used LIKE '%".$param['rechercheGlobal']."%' OR tm_ilots.coIdCompetence LIKE '%".$param['rechercheGlobal']."%' OR tm_ilots.sedIdServDem LIKE '%".$param['rechercheGlobal']."%' OR tm_ilots.enIdEntreprise LIKE '%".$param['rechercheGlobal']."%' OR tm_ilots.siIdSite LIKE '%".$param['rechercheGlobal']."%' OR `iloCodeIlot` LIKE '%".$param['rechercheGlobal']."%' OR `iloLibelleIlot` LIKE '%".$param['rechercheGlobal']."%')"; }
        }

        if(!empty($condition)) { $condition .= " AND `iloCodeBase` = '".$param['iloCodeBase']."' "; }
        else { $condition .= " `iloCodeBase` = '".$param['iloCodeBase']."' "; }

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

		WHERE ".$condition." AND (iloDateSuppression = 0 OR isnull(iloDateSuppression))
		ORDER BY `iloCodeIlot`;
	";
    }

}