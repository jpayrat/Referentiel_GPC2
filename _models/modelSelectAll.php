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

    protected function selectTousIlot($iloCodeBase) {
        $sql = $this->sqlTmIlotsRechTotale($iloCodeBase);
        //echo 'sql{'.$sql.'}';
        $this->values['nbIlots'] = RefGPC::getDB()->queryCount($sql);
        //echo 'queryCount';
        $this->values['dataIlot'] = RefGPC::getDB()->queryAll($sql);
        //echo 'queryAll';
        //var_dump($this->values[0]);
        //
        // calcul de la liste de sites
        $arrMemo = array();
        foreach($this->values['dataIlot'] as $k => $row) {
           // echo 'k {'.$k.'}';
            //var_dump($row);
           // echo $this->values['dataIlot'][$k]['iloCodeIlot'];
            
            $Liste_sites = '';
            if ($row['siIdSite'] != '')
            {	
               // echo 'recherche['.$row['siIdSite'].'] dans <br />';
                //var_dump($Liste_sites);
                if (!isset ($arrMemo[$row['siIdSite']])) {
                   // echo '<br> calcul pour ['.$row['siIdSite'].']';
                    

                    $sql2 = "SELECT t_parentzone.siIdSite, siLibelleSite "
                          . "FROM t_sites LEFT JOIN t_parentzone "
                          . "ON t_sites.siIdSite = t_parentzone.siIdSite "
                          . "WHERE t_parentzone.siIdSite_T_Sites = '".$row['siIdSite']."' ";
                    //echo '<br> $sql2{'.$sql2.'}';
                    $reponse2 = RefGPC::getDB()->queryAll($sql2);
                   // var_dump($reponse2);
                   //echo '<br> nb elem {'.RefGPC::getDB()->queryCount($sql2).'}';
                    $Liste_sites = '<b>'.$row['siLibelleSite'].' :</b><br />';
                    //echo '<br> '.$Liste_sites;
                    foreach ($reponse2 as $k => $row2) 
                    { 
                        //echo '<br> $k '. $k.' $row2 ['.$row2['siLibelleSite'].']</br>';
                        $Liste_sites .= $row2['siLibelleSite'].'<br />';
                    }
                    //echo '<br> '.$Liste_sites.' </br>';
                    $arrMemo[$row['siIdSite']] = $Liste_sites;
                   //foreach($tbListesIdSites as $k =>$v) {                        echo '<br> $k ['.$k.'] : v['.$v.']';                    }
                }
                else {
                    /*
                    if ($row['siIdSite'] != 'PO') {
                        echo '<br> deja calculé pour ['.$row['siIdSite'].'] = ['.$arrMemo[$row['siIdSite']].']';
                        echo '<br /> '.$this->values['dataIlot'][$k]['iloCodeIlot'];
                    }
                     */
                    $Liste_sites = $arrMemo[$row['siIdSite']];
                }
            }

            $this->values['dataIlot'][$k]['Liste_sites']= $Liste_sites;
            
            /*
            // mise en forme des champs
            $this->values['dataIlot']['iloCodeIlot'] = strtoupper($row['iloCodeIlot']);
            $row['iloLibelleIlot'] = strtoupper($row['iloLibelleIlot']);
            $row['iloOptim'] =  $row['iloOptim'] == 1 ? 'Oui' : 'Non';
            if ($row['used'] == '')             {  $row['used'] = ' - '; }
            if ($row['coIdCompetence'] == '')   {  $row['coIdCompetence'] = ' - '; }
            if ($row['sedIdServDem'] == '')     {  $row['sedIdServDem'] = ' - '; }
            if ($row['enIdEntreprise'] == '')   {  $row['enIdEntreprise'] = ' - '; }
            if ($row['siIdSite'] == '')         {  $row['siIdSite'] = ' - '; }
            if ($row['dacIdDomAct'] == '')      {  $row['dacIdDomAct'] = ' - '; }
    */
        }
    }

    public function getData($typeData) { 
        return $this->values[$typeData]; 
        
    }

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
