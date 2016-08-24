<?php
namespace RefGPC\_models\centre;

use \RefGPC\_systemClass\RefGPC;

class modelSelectOne
{
    protected $values = array();

    public function __construct($param) {
        $sql = $this->sqlTmCentresRechOne($param);
        $this->selectUnCentre($sql);
    }

    public function getData($indexData) {
        return $this->values[$indexData];
    }

    protected function selectUnCentre($sql) {
        $this->values['dataCentre'] = RefGPC::getDB()->queryAll($sql);
        //var_dump($this->values['dataCentre']);
    }




    protected function sqlTmCentresRechOne($param) {
        return "

        SELECT DISTINCT
        `cenCodeCentre`,
        `cenLibelleCentre`,
        `cenZones`,
        `cenCentreOrigine`,
        tm_centres.tnraTypeNRA,
        t_typenra.tnraLibelleTypeNRA,
        `cenBlocageR2`,
        `cenInfoR2`,
        `cenNumero`,
        `cenRue`,
        `cenCodePostal`,
        tm_centres.rhIlot,
        `cenCoordGPSLambert2COX`,
        `cenCoordGPSLambert2COY`,
        tm_centres.siIdSite,
        t_sites.siLibelleSite,
        tm_centres.zeCodeZoneETR,
        t_zoneetr.zeLibelleZoneETR,
        `cenZoneBlanche`,
        `cenNRAOkNok`,
        `cenInfoAdmin`,
        `cenDateCreation`,
        `cenDateSuppression`,
        `cenDateModif`,
        t_rephab.rhVille,
        t_rephab.enIdEntreprise,
        t_rephab.trhTypeRepHab,
        t_rephab.rhHoraire,
        t_rephab.rhNumero,
        t_rephab.rhImprimante,
        t_rephab.rhTechnicien,
        t_typeRepHab.trhLibelleTypeRepHab
        
		
		FROM tm_centres
		  LEFT JOIN t_sites ON tm_centres.siIdSite = t_sites.siIdSite
		  LEFT JOIN t_zoneetr ON tm_centres.zeCodeZoneETR = t_zoneetr.zeCodeZoneETR 
		  LEFT JOIN t_typenra ON tm_centres.tnraTypeNRA = t_typenra.tnraTypeNRA
		  LEFT JOIN t_rephab ON tm_centres.rhIlot = t_rephab.rhIlot
		  LEFT JOIN t_typeRepHab ON t_rephab.trhTypeRepHab = t_typeRepHab.trhTypeRepHab
		  
		WHERE `cenCodeCentre` = '".$param['centre']."' AND `cenCodeBase` = '".$param['cenCodeBase']."'  AND (cenDateSuppression = 0 OR isnull(cenDateSuppression))
		ORDER BY `cenCodeCentre`;
		
		/*
		SELECT DISTINCT 
		iloCodeCentre, 
		iloLibelleCentre, 
		iloOptim, 
		iloCodeEtablissement, 
		iloCodeBase, 
		iloInfo, 
		iloInfoAdmin, 
		iloDateCreation, 
		iloDateModif, 
		iloDateSuppression, 
		used, 
		tm_Centres.sedIdServDem, 
		tm_Centres.prsIdProdSav, 
		tm_Centres.dacIdDomAct, 
		tm_Centres.coIdCompetence, 
		tm_Centres.siIdSite, 
		tm_Centres.enIdEntreprise, 
		tm_Centres.fiIdFiltrage, 
		tm_Centres.tiIdTypeIot, 
		tm_Centres.banIdBandeau, 
		
		sedLibelleServDem, 
		prsLibelleProdSav, 
		daLibelleDomAct, 
		daDetailDomAct, 
		coLibelleCompetence, 
		tiLibelleTypeCentre, 
		banLibelleBandeau, 
		fiLibelleFiltrage , 
		enLibelleEntreprise, 
		enZoneETREntreprise, 
		siLibelleSite, 
		siOldIdSide, 
		siOldNameSite, 
		siOldZoneSite, 
		siZoneEtlSite
		
		FROM tm_Centres 
		LEFT JOIN t_servicedemandeur ON tm_Centres.sedIdServDem = t_servicedemandeur.sedIdServDem 
		LEFT JOIN t_prodsav ON tm_Centres.prsIdProdSav = t_prodsav.prsIdProdSav 
		LEFT JOIN t_domaineactivite ON tm_Centres.dacIdDomAct = t_domaineactivite.dacIdDomAct
		LEFT JOIN t_competences ON tm_Centres.coIdCompetence = t_competences.coIdCompetence 
		LEFT JOIN t_typeCentre ON tm_Centres.tiIdTypeIot = t_typeCentre.tiIdTypeIot 
		LEFT JOIN t_bandeau ON tm_Centres.banIdBandeau = t_bandeau.banIdBandeau 
		LEFT JOIN t_filtrage ON tm_Centres.fiIdFiltrage = t_filtrage.fiIdFiltrage 
		LEFT JOIN t_entreprise ON tm_Centres.enIdEntreprise = t_entreprise.enIdEntreprise 
		LEFT JOIN t_sites ON tm_Centres.siIdSite = t_sites.siIdSite 

		*/
	";
    }

}