<?php

namespace RefGPC\_controleurs;
use \RefGPC\_models\ilot\ModelVue;
use \RefGPC\_models\ilot\Formulaire;

/**
 * Description of adminControleur
 *
 * @author Marc
 */
class adminControleur extends baseControleur{
    
    public function __construct($base) {
        parent::__construct($base);
    }


    public  function affIndex($params) {

        $form = new Formulaire($this->codeBase); // choixBase->codeBase());
        $this->d['corps']['inputIlotGlobal'] = $form->input('rechercheIlotGlobal', '30','28');
        $this->d['corps']['inputIlotTape'] = $form->input('rechercheIlotTape','3','3');

        // var_dump($this->d);
        $vue = new ModelVue($this->d);

        $vue->afficheHaut($this->d['haut'], ''); // Le second paramètre = fichier js à inclure
//        $vue->afficheMenuLateral($this->d['lateral']);

        $vue->afficheCorps($this->d['corps'], 'affIndexAdmin');// TODO : je n'arrive pas à automatiser le "affIndex"
        $vue->afficheBas();
    }

}
