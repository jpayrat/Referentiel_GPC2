<?php
namespace RefGPC\_models;

class menuLateral
{

    public function classCSSMenuLateralActifIlot($menu)
    {
        if ($menu == 'ilot') { $classLienMenuLateralIlot = 'actif'; } else { $classLienMenuLateralIlot = ''; }
        return $classLienMenuLateralIlot;
    }

    public function classCSSMenuLateralActifCentre($menu)
    {
        if ($menu == 'centre') { $classLienMenuLateralCentre = 'actif'; } else { $classLienMenuLateralCentre = ''; }
        return $classLienMenuLateralCentre;
    }
    
}