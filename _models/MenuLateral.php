<?php
namespace RefGPC\_models;

class menuLateral
{
    var $cssIlot;
    var $cssCentre;
    var $cssTech;

    public function __construct($menu='')
    {
        $this->cssIlot = $menu == 'ilot' ? 'actif' : '';
        $this->cssCentre = $menu == 'centre' ? 'actif' : '';
        $this->cssTech = $menu == 'tech' ? 'actif' : '';
    }

    public function classCSSMenuLateralActifIlot()  { return $this->cssIlot;  }
    public function classCSSMenuLateralActifCentre(){ return $this->cssCentre;  }
    public function classCSSMenuLateralActifTech()  { return $this->cssTech;  }
    
}