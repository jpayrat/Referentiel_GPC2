<?php

namespace RefGPC\_models\ilot;

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
        $this->base = $choixUI;
        //var_dump($this->ui);
    }
    
    public function libelleBase() { return $this->base == 'LR' ? 'Languedoc-Roussillon' : 'Midi-Pyrénées';  }
    public function codeBase() { return $this->base == 'LR'? 'K2' : 'T1';  }
    public function classCSSLien($ui) { return $ui == $this->base ?  'actif' : ''; }   
    // 
    
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
            // codage UTF-8 dans la base donc recodage en "ISO-8859-1" : pour windows
            foreach ($row as $key => $value) {
                    $row[$key] = mb_convert_encoding($value, "ISO-8859-1", "UTF-8");
            }           
            $line = implode(";", $row);
            fwrite ($myfile, $line. "\r\n" ); 
            //var_dump($line);
        }
 	// ----- fin de fichier
	fclose ($myfile);
	return true;       
    }
    
}
