<?php

namespace RefGPC\_models;

use \RefGPC\_systemClass\RefGPC;

class Formulaire {

    private $data;
    private $codeBase;

    /**
     * code base en 1er parametre : K2 ou T1
     * @param type $data
     */
    public function __construct($data) {
        //echo '<br /> Form::__construc ['.$data.']';
        // var_dump($data);
        $this->codeBase = is_array($data) ? $data[0] : $data;
        $this->data = $data;
        //var_dump($this->codeBase );
    }

    public function input($name, $size, $maxLength, $placeholder='', $colorPlaceholder='', $class='') {
        return '<input class="' .$class. ' ' .$colorPlaceholder. '" type="text" name="' . $name . '" id="' . $name . '" size="' . $size . '" maxlength="' . $maxLength . '" placeholder="' . $placeholder . '"></input>';
    }

    public function inputPasswd($name, $size, $maxLength, $placeholder='', $colorPlaceholder='', $class='') {
        return '<input class="' .$class. ' ' .$colorPlaceholder. '" type="password" name="' . $name . '" id="' . $name . '" size="' . $size . '" maxlength="' . $maxLength . '" placeholder="' . $placeholder . '"></input>';
    }

    public function textarea($name, $value, $cols, $rows, $maxlength){
        return '<textarea id="'.$name.'" name="'.$name.'" cols="'.$cols.'" rows="'.$rows.'" maxlength="'.$maxlength.'" placeholder="'.$value.'">'.$value.'</textarea>';
    }

    public function select($name) {
        //echo '$varReturn'.$varReturn.']';
        //echo '<br />name '.$name.']';
        $varReturn = '<select id="' . $name . '" name="' . $name . '">';
        $varReturn .= '<option value="***" selected="selected">Tous</option>';

        switch ($name) {
        /******** Select pour les îlots *************/
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
                    $varReturn .= '    <option>' . $row['tiIdTypeIot'] . ' </option>' . "\n";
                }
                break;

            case 'used':
                $sql = "SELECT `used` FROM `t_used` ORDER BY `used` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    $varReturn .= '<option>' . $row['used'] . ' </option>' . "\n";
                }
                break;

            case 'competence':
                $sql = "SELECT DISTINCT t_competences.coIdCompetence FROM `TM_Ilots` LEFT JOIN t_competences ON t_competences.coIdCompetence = tm_ilots.coIdCompetence WHERE coCodeBase = '" . $this->codeBase . "' ORDER BY `coIdCompetence` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    $varReturn .= '<option value="' . addslashes($row['coIdCompetence']) . '">' . addslashes($row['coIdCompetence']) . ' </option>' . "\n";
                }
                break;

            case 'serviceCible':
                $sql = "SELECT DISTINCT t_servicedemandeur.sedIdServDem FROM `TM_Ilots` LEFT JOIN t_servicedemandeur ON t_servicedemandeur.sedIdServDem = tm_ilots.sedIdServDem WHERE sedCodeBase = '" . $this->codeBase . "' ORDER BY `sedIdServDem` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    $varReturn .= '<option value="' . $row['sedIdServDem'] . '">' . $row['sedIdServDem'] . ' </option>' . "\n";
                }
                break;

            case 'entreprise':
                $sql = "SELECT DISTINCT t_entreprise.enIdEntreprise, t_entreprise.enLibelleEntreprise FROM `TM_Ilots` LEFT JOIN t_entreprise ON t_entreprise.enIdEntreprise = tm_ilots.enIdEntreprise WHERE enCodeBase = '" . $this->codeBase . "' ORDER BY `enIdEntreprise` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    $varReturn .= '<option value="' . $row['enIdEntreprise'] . '">' . $row['enLibelleEntreprise'] . ' ( ' . $row['enIdEntreprise'] . ')</option>' . "\n";
                }
                break;

            case 'siteGeo':
                $sql = "SELECT DISTINCT t_sites.siIdSite, t_sites.siLibelleSite FROM `TM_Ilots` LEFT JOIN t_sites ON t_sites.siIdSite = tm_ilots.siIdSite WHERE siCodeBase = '" . $this->codeBase . "' ORDER BY `siLibelleSite` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    $varReturn .= '<option value="' . $row['siIdSite'] . '">' . $row['siLibelleSite'] . '</option>' . "\n";
                }
                break;

            case 'domaineAct':
                $sql = "SELECT DISTINCT t_domaineactivite.dacIdDomAct, t_domaineactivite.daLibelleDomAct FROM `TM_Ilots` LEFT JOIN t_domaineactivite ON t_domaineactivite.dacIdDomAct = tm_ilots.dacIdDomAct WHERE daCodeBase = '" . $this->codeBase . "' ORDER BY `daLibelleDomAct` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    $varReturn .= '<option value="' . $row['dacIdDomAct'] . '">' . $row['dacIdDomAct'] . ' - ' . $row['daLibelleDomAct'] . ' </option>' . "\n";
                }
                break;
            /******** Fin des Select pour les îlots *************/


            /******** Select pour les Centres *************/
            case 'centreList':
                $sql = "SELECT DISTINCT `cenCodeCentre`, `cenLibelleCentre` FROM `TM_Centres` WHERE `cenCodeBase` = '" . $this->codeBase . "' ORDER BY `cenCodeCentre` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    $varReturn .= '<option>' . $row['cenCodeCentre'] . ' - ' . $row['cenLibelleCentre'] . '</option>';
                }
                break;

            case 'zoneETR':
                $sql = "SELECT DISTINCT `zeCodeZoneETR`, `zeLibelleZoneETR` FROM `T_zoneETR` ORDER BY `zeCodeZoneETR` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    $varReturn .= '<option value="'.$row['zeCodeZoneETR'].'">' . $row['zeCodeZoneETR'] . ' - ' . $row['zeLibelleZoneETR'] . '</option>';
                }
                break;

            case 'idSiteGPC':
                $sql = "SELECT DISTINCT tm_centres.siIdSite, t_sites.siLibelleSite FROM `TM_centres`
		                                LEFT JOIN t_sites ON tm_centres.siIdSite = t_sites.siIdSite
		                                ORDER BY `siIdSite` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    $varReturn .= '<option value="'.$row['siIdSite'].'">' . $row['siLibelleSite'] . '</option>';
                }
                break;

            case 'NRA':

                    $varReturn .= '<option value="0">Sans les NRA Non OK</option>';
                    $varReturn .= '<option value="1">Uniquement les NRA Non OK</option>';

                break;

            case 'repHab':

                $varReturn .= '<option value="IS NULL">Sans les répartiteurs habités </option>';
                $varReturn .= '<option value="IS NOT NULL">Uniquement les répartiteurs habités</option>';

                break;

            case 'zoneBlanche':

                $varReturn .= '<option value="0">Sans les zones blanches </option>';
                $varReturn .= '<option value="1">Uniquement les zones blanches</option>';

                break;

            case 'blocageR2':
                $varReturn .= '<option value="IS NULL">Sans les blocages R2 </option>';
                $varReturn .= '<option value="IS NOT NULL">Uniquement les blocage R2</option>';
                break;


            /******** Fin des Select pour les centres *************/

            default :;
        }

        $varReturn .= '</select>';

        return $varReturn;
    }


    public function selectAdmin($name, $value) {
        //echo '$varReturn'.$varReturn.']';
        //echo '<br />name '.$name.']';
        $varReturn = '<select id="' . $name . '" name="' . $name . '">';
        $varReturn .= '<optgroup label="'.$value.'">';

        switch ($name) {

            case 'used':
                $sql = "SELECT `used` FROM `t_used` ORDER BY `used` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    if($row['used'] == $value){$varReturn .= '<option selected>' . $row['used'] . ' </option>' . "\n";}
                    else {$varReturn .= '<option>' . $row['used'] . ' </option>' . "\n";}
                }
                break;
            
            case 'coIdCompetence':
                $sql = "SELECT DISTINCT t_competences.coIdCompetence FROM `TM_Ilots` LEFT JOIN t_competences ON t_competences.coIdCompetence = tm_ilots.coIdCompetence WHERE coCodeBase = '" . $this->codeBase . "' ORDER BY `coIdCompetence` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    if($row['coIdCompetence'] == $value){$varReturn .= '<option selected>' . $row['coIdCompetence'] . ' </option>' . "\n";}
                    else {$varReturn .= '<option>' . $row['coIdCompetence'] . ' </option>' . "\n";}
                }
                break;
            
            case 'sedIdServDem':
                $sql = "SELECT DISTINCT t_servicedemandeur.sedIdServDem FROM `TM_Ilots` LEFT JOIN t_servicedemandeur ON t_servicedemandeur.sedIdServDem = tm_ilots.sedIdServDem WHERE sedCodeBase = '" . $this->codeBase . "' ORDER BY `sedIdServDem` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    if($row['sedIdServDem'] == $value){$varReturn .= '<option selected>' . $row['sedIdServDem'] . ' </option>' . "\n";}
                    else {$varReturn .= '<option>' . $row['sedIdServDem'] . ' </option>' . "\n";}
                }
                break;
            
            case 'dacIdDomAct':
                $sql = "SELECT DISTINCT t_domaineactivite.dacIdDomAct, t_domaineactivite.daLibelleDomAct FROM `TM_Ilots` LEFT JOIN t_domaineactivite ON t_domaineactivite.dacIdDomAct = tm_ilots.dacIdDomAct WHERE daCodeBase = '" . $this->codeBase . "' ORDER BY `daLibelleDomAct` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    if($row['dacIdDomAct'] == $value){$varReturn .= '<option selected>' . $row['dacIdDomAct'] . ' </option>' . "\n";}
                    else {$varReturn .= '<option>' . $row['dacIdDomAct'] . ' </option>' . "\n";}
                }
                break;

            case 'daDetailDomAct':
                $sql = "SELECT DISTINCT `daDetailDomAct` FROM `t_domaineactivite`  WHERE `daCodeBase` = '" . $this->codeBase . "' ORDER BY `dacIdDomAct` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    if($row['daDetailDomAct'] == $value){$varReturn .= '<option selected>' . $row['daDetailDomAct'] . ' </option>' . "\n";}
                    else {$varReturn .= '<option>' . $row['daDetailDomAct'] . ' </option>' . "\n";}
                }
                break;
            
            case 'enIdEntreprise':
                $sql = "SELECT DISTINCT t_entreprise.enIdEntreprise, t_entreprise.enLibelleEntreprise FROM `TM_Ilots` LEFT JOIN t_entreprise ON t_entreprise.enIdEntreprise = tm_ilots.enIdEntreprise WHERE enCodeBase = '" . $this->codeBase . "' ORDER BY `enIdEntreprise` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    if($row['enIdEntreprise'] == $value){$varReturn .= '<option selected>' . $row['enIdEntreprise'] . ' </option>' . "\n";}
                    else {$varReturn .= '<option>' . $row['enIdEntreprise'] . ' </option>' . "\n";}
                }
                break;

            case 'prsIdProdSav':
                $sql = "SELECT DISTINCT `prsIdProdSav` FROM `t_prodsav` ORDER BY `prsIdProdSav` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    if($row['prsIdProdSav'] == $value){$varReturn .= '<option selected>' . $row['prsIdProdSav'] . ' </option>' . "\n";}
                    else {$varReturn .= '<option>' . $row['prsIdProdSav'] . ' </option>' . "\n";}
                }
                break;

            case 'siIdSite':
                $sql = "SELECT DISTINCT t_sites.siIdSite, t_sites.siLibelleSite FROM `TM_Ilots` LEFT JOIN t_sites ON t_sites.siIdSite = tm_ilots.siIdSite WHERE siCodeBase = '" . $this->codeBase . "' ORDER BY `siLibelleSite` ";
                $rep = RefGPC::getDB()->queryAll($sql);
                foreach ($rep as $row) {
                    if($row['siIdSite'] == $value){$varReturn .= '<option selected>' . $row['siIdSite'] . ' </option>' . "\n";}
                    else {$varReturn .= '<option>' . $row['siIdSite'] . ' </option>' . "\n";}
                }
                break;



            default :;
        }

        $varReturn .= '</select>';

        return $varReturn;
    }

}
