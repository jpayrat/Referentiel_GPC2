<?php

namespace RefGPC\_controleurs\admin;

use \RefGPC\_controleurs\baseControleur;

use \RefGPC\_models\ModelVue;
use \RefGPC\_models\Formulaire;

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

        $vue->afficheAdminCorps($this->d['corps'], 'affIndexAdmin');// TODO : je n'arrive pas à automatiser le "affIndex"
        $vue->afficheBas();
    }


    // Algorithme de l'administration du site :
    /*
     *  > De base on arrive sur affIndex
     *  Si les variables de session N'EXISTENT PAS
     *  alors on affiche le formulaire d'autentification et dans la barre horizontale on affiche "administration"
     *
     *  Si les variables de session EXISTENT
     *  alors on affiche la page d'administration et dans la barre horizontale on affiche le login
     *
     * ----
     * Le lien LOGIN sera du type AD\admin\profilAdmin
     * il faudra ajouter des sorties de ces méthodes pour gérer les appels directs à ces liens
     *
     * La CROIX du lient LOGIN sera du type AD\admin\deconnexion
     * il faudra ajouter des sorties de ces méthodes pour gérer les appels directs à ces liens
     *
     * Le lien ADMINISTRATION sera du type AD\admin\connexion
     * il faudra ajouter des sorties de ces méthodes pour gérer les appels directs à ces liens
     *
     * S'il n'y a rien après AD\admin, alors on execute la méthode AD\admin\affIndex qui va déterminer
     * quelle méthode il faut appeler en fonction des valeurs de session
     *
     *
     * Il n'y a plus qu'a tester tout ça avec les envois de $_POST
     *
     * A la suite de ça il faudra appliquer une condition à la page modelSelectOne pour
     * à la place d'afficher du text,
     * afficher des textarea / input et autres select en version admin ...
     *
     */




}
