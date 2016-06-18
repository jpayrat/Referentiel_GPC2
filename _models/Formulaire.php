<?php
namespace RefGPC\_models;
use \RefGPC\_systemClass\RefGPC;

class Formulaire
{
    private $data;
    private $codeBase;
    
    /**
     * code base en 1er parametre
     * @param type $data
     */
    public function __construct($data)
    {
        //echo '<br /> Form::__construc ['.$data.']';
       // var_dump($data);
	$this->codeBase = is_array($data) ? $data[0] : $data;
       $this->data = $data;
        //var_dump($this->codeBase );

    }
    
    public function input($name, $size, $maxLength)
    {
        return '<input type="text" name="'.$name.'" id="'.$name.'" size="'.$size.'" maxlength="'.$maxLength.'" ></input>';
    }

    public function select($name)
    {
        //echo '$varReturn'.$varReturn.']';
        //echo '<br />name '.$name.']';
        $varReturn = '<select id="' . $name . '" name="' . $name . '">';
        $varReturn .= '<option value="***" selected="selected">Tous</option>';

        switch ($name) {

            case 'ilotList':
                $sql = "SELECT DISTINCT `iloCodeIlot`, `iloLibelleIlot` FROM `TM_Ilots` WHERE `iloCodeBase` = '" . $this->codeBase . "' ORDER BY `iloCodeIlot` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    $varReturn .= '<option>' . $row['iloCodeIlot'] . ' - ' . $row['iloLibelleIlot'] . '</option>';
                    //echo '$varReturn'.$varReturn.']';
                }
                break;

            case 'typeIlot':
                $sql = "SELECT DISTINCT `tiIdTypeIot` FROM `TM_Ilots` WHERE `iloCodeBase` = '" . $this->codeBase . "' ORDER BY `tiIdTypeIot` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    $varReturn .= '    <option>' . $row['tiIdTypeIot'] . ' </option>'."\n";
                }
                break;

            case 'used':
                $sql = "SELECT `used` FROM `t_used` ORDER BY `used` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    $varReturn .= '<option>' . $row['used'] . ' </option>'."\n";
                }
                break;

            case 'competence':
                $sql = "SELECT DISTINCT t_competences.coIdCompetence FROM `TM_Ilots` LEFT JOIN t_competences ON t_competences.coIdCompetence = tm_ilots.coIdCompetence WHERE coCodeBase = '" . $this->codeBase . "' ORDER BY `coIdCompetence` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    $varReturn .= '<option value="' . addslashes($row['coIdCompetence']) . '">' . addslashes($row['coIdCompetence']) . ' </option>'."\n";
                }
                break;

            case 'serviceCible':
                $sql = "SELECT DISTINCT t_servicedemandeur.sedIdServDem FROM `TM_Ilots` LEFT JOIN t_servicedemandeur ON t_servicedemandeur.sedIdServDem = tm_ilots.sedIdServDem WHERE sedCodeBase = '" . $this->codeBase . "' ORDER BY `sedIdServDem` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    $varReturn .= '<option value="' . $row['sedIdServDem'] . '">' . $row['sedIdServDem'] . ' </option>'."\n";
                }
                break;

            case 'entreprise':
                $sql = "SELECT DISTINCT t_entreprise.enIdEntreprise, t_entreprise.enLibelleEntreprise FROM `TM_Ilots` LEFT JOIN t_entreprise ON t_entreprise.enIdEntreprise = tm_ilots.enIdEntreprise WHERE enCodeBase = '" . $this->codeBase . "' ORDER BY `enIdEntreprise` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    $varReturn .= '<option value="' . $row['enIdEntreprise'] . '">' . $row['enLibelleEntreprise'] . ' ( ' . $row['enIdEntreprise'] . ')</option>'."\n";
                }
                break;

            case 'siteGeo':
                $sql = "SELECT DISTINCT t_sites.siIdSite, t_sites.siLibelleSite FROM `TM_Ilots` LEFT JOIN t_sites ON t_sites.siIdSite = tm_ilots.siIdSite WHERE siCodeBase = '" . $this->codeBase . "' ORDER BY `siLibelleSite` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    $varReturn .= '<option value="' . $row['siIdSite'] . '">' . $row['siLibelleSite'] . '</option>'."\n";
                }
                break;

            case 'domaineAct':
                $sql = "SELECT DISTINCT t_domaineactivite.dacIdDomAct, t_domaineactivite.daLibelleDomAct FROM `TM_Ilots` LEFT JOIN t_domaineactivite ON t_domaineactivite.dacIdDomAct = tm_ilots.dacIdDomAct WHERE daCodeBase = '" . $this->codeBase . "' ORDER BY `daLibelleDomAct` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    $varReturn .= '<option value="' . $row['dacIdDomAct'] . '">' . $row['dacIdDomAct'] . ' - ' . $row['daLibelleDomAct'] . ' </option>'."\n";
                }
                break;

             default : ;
        }

        $varReturn .= '</select>';

        return $varReturn;
    }

}

