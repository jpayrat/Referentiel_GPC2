<?php

namespace RefGPC\_models\centre;

use \RefGPC\_systemClass\RefGPC;

class modelSelectAny
{
    protected $values = array();

    public function __construct($param) {
        $sql = $this->sqlTmCentresRech($param);
        $_SESSION['sql_Csv'] = $sql;
        $this->selectAnyCentre($sql);
    }

    public function getData($indexData) {
        return $this->values[$indexData];
    }

    protected function selectAnyCentre($sql){
        $this->values['nbCentre'] = RefGPC::getDB()->queryCount($sql);
        $this->values['dataCentre'] = RefGPC::getDB()->queryAll($sql);
    }

    protected function sqlTmCentresRech($param)
    {
        $condition = '';

        if($param['zoneETR'] != '***')
        {
            if(!empty($condition)) { $condition .= " AND"; } 
            $condition .= " tm_centres.zeCodeZoneETR = '".$param['zoneETR']."' ";
        }
        if($param['idSiteGPC'] != '***')
        {
            if(!empty($condition)) { $condition .= " AND"; }
            $condition .= " tm_centres.siIdSite = '".$param['idSiteGPC']."' ";
        }
        if($param['NRA'] != '***')
        {
            if(!empty($condition)) { $condition .= " AND"; }
            $condition .= " tm_centres.cenNRAOkNok = '".$param['NRA']."' ";
        }
        if($param['repHab'] != '***')
        {
            if(!empty($condition)) { $condition .= " AND"; } 
            $condition .= " tm_centres.rhIlot ".$param['repHab']." ";
        }
        if($param['zoneBlanche'] != '***')
        {
            if(!empty($condition)) { $condition .= " AND"; } 
            $condition .= " tm_centres.cenZoneBlanche = '".$param['zoneBlanche']."' ";
        }
        if($param['blocageR2'] != '***')
        {
            if(!empty($condition)) { $condition .= " AND"; } 
            $condition .= " tm_centres.cenBlocageR2 ".$param['blocageR2']." ";
        }

        // Recherche ducentre et gestion de la recherche globale
        if($param['centre'] != '')
        {
            if(!empty($condition)) { $condition .= " AND"; } 
            $condition .= " `cenCodeCentre` LIKE '%".$param['centre']."%' ";
        }
        if($param['rechercheCentreGlobal'] != '')
        {
            if(!empty($condition)) { $condition .= " AND"; } 
            $condition .= " (tm_centres.cenCodeCentre LIKE '%".$param['rechercheCentreGlobal']."%' OR tm_centres.cenLibelleCentre LIKE '%".$param['rechercheCentreGlobal']."%' OR tm_centres.siIdSite LIKE '%".$param['rechercheCentreGlobal']."%' OR t_sites.siLibelleSite LIKE '%".$param['rechercheCentreGlobal']."%' OR tm_centres.cenInfoAdmin LIKE '%".$param['rechercheCentreGlobal']."%' )";
        }

        if(!empty($condition)) { $condition .= " AND"; } 
        $condition .= " `cenCodeBase` = '".$param['cenCodeBase']."' ";

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
		  
		WHERE ".$condition." AND (cenDateSuppression = 0 OR isnull(cenDateSuppression))
		ORDER BY `cenCodeCentre`;
	";
    }

}