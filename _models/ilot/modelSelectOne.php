<?php
namespace RefGPC\_models\ilot;

use \RefGPC\_systemClass\RefGPC;

class modelSelectOne
{
    protected $values = array();

    public function __construct($param) {
        $sql = $this->sqlTmIlotsRechOne($param);
        $this->selectUnIlot($sql);
    }

    public function getData($indexData) {
        return $this->values[$indexData];
    }

    protected function selectUnIlot($sql) {
        $this->values['dataIlot'] = RefGPC::getDB()->queryAll($sql);
        //var_dump($this->values['dataIlot']);
    }




    protected function sqlTmIlotsRechOne($param) {
        return "
		SELECT DISTINCT 
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

		WHERE iloCodeIlot = '".$param['ilot']."' AND iloCodeBase = '".$param['iloCodeBase']."' AND (iloDateSuppression = 0 OR isnull(iloDateSuppression));
	
	";
    }

}