<?php

namespace RefGPC\_models\centre;

use \RefGPC\_systemClass\RefGPC;
/**
 * Description of modelIlot
 * datas about ilot
 * @author Marc
 */
class modelIlot {
    
    protected $base; // LR ou MP
    
    function __construct($choixUI ='') {
        //var_dump($choixUI);
    //    $this->base = $choixUI;
        //var_dump($this->ui);
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

    public function organizeListZone($dataIlot, $arrListeZone){
        
        foreach ($dataIlot as $k => $row) {
            if (isset($arrListeZone[$row['siIdSite']])) {
                $dataIlot[$k]['Liste_sites'] = $arrListeZone[$row['siIdSite']];
            } else {
                $dataIlot[$k]['Liste_sites'] = '';
            }

            // mise en forme des champs
            $dataIlot[$k]['iloCodeIlot'] = strtoupper($row['iloCodeIlot']);
            $dataIlot[$k]['iloLibelleIlot'] = strtoupper($row['iloLibelleIlot']);
            $dataIlot[$k]['iloOptim'] = $row['iloOptim'] == 1 ? 'Oui' : 'Non';
            if ($row['used'] == '') {
                $dataIlot[$k]['used'] = ' - ';
            }
            if ($row['coIdCompetence'] == '') {
                $dataIlot[$k]['coIdCompetence'] = ' - ';
            }
            if ($row['sedIdServDem'] == '') {
                $dataIlot[$k]['sedIdServDem'] = ' - ';
            }
            if ($row['enIdEntreprise'] == '') {
                $dataIlot[$k]['enIdEntreprise'] = ' - ';
            }
            if ($row['siIdSite'] == '') {
                $dataIlot[$k]['siIdSite'] = ' - ';
            }
            if ($row['dacIdDomAct'] == '') {
                $dataIlot[$k]['dacIdDomAct'] = ' - ';
            }
        }

        return $dataIlot;
    }

    
    /**
     * Cree le fichier csv sur le serveur.
     * @return true si fichier cree.
     * TODO :  affichage complet uniquement dispo pour les admins 
     * - recuperer le login courant et les logins autorisés
     * - autoriser la modif du sql que pour les login admins
     *
     */
    public function createExtractFile($filename = 'extractionIlots') {
        $sql = isset($_SESSION['sql_Csv']) ? $_SESSION['sql_Csv'] : '';
        
        $parts = explode ("FROM", $sql);
	$sql = 'select DISTINCT tm_ilots.iloCodeIlot, tm_ilots.iloLibelleIlot, tm_ilots.iloOptim, tm_ilots.iloCodeEtablissement, tm_ilots.iloCodeBase, tm_ilots.iloInfo, tm_ilots.iloInfoAdmin, tm_ilots.iloDateCreation, tm_ilots.iloDateModif, tm_ilots.iloDateSuppression, tm_ilots.used, tm_ilots.sedIdServDem, tm_ilots.prsIdProdSav, tm_ilots.dacIdDomAct, tm_ilots.coIdCompetence, tm_ilots.siIdSite, tm_ilots.enIdEntreprise, tm_ilots.fiIdFiltrage, tm_ilots.tiIdTypeIot, tm_ilots.banIdBandeau';
	if (isset($parts[1])) {
            $sql .= ' from '.$parts[1];
        }
        else {
            $sql .= ' from tm_ilots';
        }
	$pathToFile = PATH.'temp/'.$filename.'.csv';
	$myfile = fopen($pathToFile, "w") ;	// echo '<br>pathToFile :'.$pathToFile;
        if ($myfile == FALSE) return false; // erreur de fichier
        $nbIlots = RefGPC::getDB()->queryCount($sql);
        if ($nbIlots < 1) return false;
        
        $dataIlot = RefGPC::getDB()->queryAll($sql);
        // titres
        $entete = array_keys($dataIlot[0]);
        $line = implode(";", $entete);
        fwrite ($myfile, $line. "\r\n" ); 
        //var_dump($line);
        
        foreach ($dataIlot as $k => $row) {
            if (array_key_exists('iloLibelleIlot', $row)) {
                $row['iloLibelleIlot'] = rtrim ($row['iloLibelleIlot']);
            }
            if (array_key_exists('iloDateModif', $row)) {
				$row['iloDateModif'] = $this->stamp2Date($row['iloDateModif']);
            }			
            if (array_key_exists('iloDateCreation', $row)) {
				$row['iloDateCreation'] = $this->stamp2Date($row['iloDateCreation']);
            }			
            if (array_key_exists('iloDateSuppression', $row)) {
				$row['iloDateSuppression'] = $this->stamp2Date($row['iloDateSuppression']);
            }
            if (array_key_exists('iloInfo', $row)) {
				$row['iloInfo'] = str_replace("\r\n", "", $row['iloInfo']); // filtre  les 'retour chariot' qui provoquent une detection de nouveau champ
            }
			
            // codage UTF-8 dans la base donc recodage en "ISO-8859-1" : pour windows
            foreach ($row as $key => $value) {
                    $row[$key] = mb_convert_encoding($value, "ISO-8859-1", "UTF-8");
            }           
            $line = implode(";", $row);
            fwrite ($myfile, $line. "\r\n" ); 
			//if ($row['iloCodeIlot']=="39S") {
			//	var_dump($line);
			//}
			
			
			
        }
 	// ----- fin de fichier
	fclose ($myfile);
	return true;       
    }
    // ------------------------------------------------------------------------
    // modeles des données des ilots

	/**
	 * Retourne la date au format jj/mm/aaaa
	 * avec une timestamp
	 * @param String $timestamp exemple : 1458660256
	 * @return String : 31/03/2016
	 */
	private function stamp2Date($timestamp) {
		if ($timestamp == 0) {
			return "";
		}
		$convdate =  new \DateTime();
		$convdate->setTimestamp($timestamp);
		return $convdate->format('d/m/Y');
	}
}
