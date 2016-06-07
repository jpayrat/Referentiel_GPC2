<?php

namespace RefGPC\_controleurs;

use RefGPC\_models\ChoixBase;
use RefGPC\_models\MenuLateral;
use \RefGPC\_models\Formulaire;
use \RefGPC\_models\ModelVue;
use \RefGPC\_models\Routeur;

use \RefGPC\_systemClass\RefGPC; // RefGPC::getDB()

/**
 * recupère les données pour l'affichage des ilots et les envoie à la vue.
 * Controleur permettant d'afficher la page d'accueil des îlots comprenant :
 * -> La mise en évidence de la base choisie dans le menu horizontal LR ou MP
 * -> Le menu latéral en ayant surligné ilot
 * -> Le titre - agrémenté de LR ou MP selon la base choisie
 * -> Le formulaire de recherche globale
 * -> Le formulaire multi-critères
 * -> Les boutons "Tout lister" et "Réinit Formulaire"
 * -> Eventuellement un historique des modifications
 **/

class ilotControleur extends baseControleur {

    public function affIndex($params) {




        var_dump($params);




        $d = array(); // tableau collectant les données

        $d['haut']['lienHorizLR'] = WEBPATH.'LR/ilot';
        $d['haut']['lienHorizMP'] = WEBPATH.'MP/ilot';

        $param = is_array($params) ? $params[0] : $params;
        //echo '('.$param.')';
        $choixBase = new ChoixBase($param);
        $d['corps']['codeBase'] = $choixBase->codeBase();
        $d['corps']['libelleBase'] = $choixBase->libelleBase();
        $d['haut']['classCSSLienLR'] = $choixBase->classCSSLien('LR');
        $d['haut']['classCSSLienMP'] = $choixBase->classCSSLien('MP');

        $menuLateral = new menuLateral();
        $d['lateral']['classLienMenuLateralIlot'] = $menuLateral->classCSSMenuLateralActifIlot('ilot');
        $d['lateral']['classLienMenuLateralCentre'] = $menuLateral->classCSSMenuLateralActifCentre('ilot');

        $form = new Formulaire($choixBase->codeBase());
        $d['corps']['selectIlotList'] = $form->select('ilotList');
        $d['corps']['selectTypeIlot'] = $form->select('typeIlot');
        $d['corps']['selectUsed'] = $form->select('used');
        $d['corps']['selectCompetence'] = $form->select('competence');
        $d['corps']['selectServiceCible'] = $form->select('serviceCible');
        $d['corps']['selectEntreprise'] = $form->select('entreprise');
        $d['corps']['selectSiteGeo'] = $form->select('siteGeo');
        $d['corps']['selectDomaineAct'] = $form->select('domaineAct');

        $d['corps']['nbIlot'] = RefGPC::getDB()->queryCount('SELECT iloCodeIlot FROM `tm_ilots`');
        //var_dump($d);

        
        $vue = new ModelVue($d);
        extract($d);
        //echo $classCSSLienMP;
        //var_dump($d['haut']);
        //var_dump($d);
        $vue->afficheHaut($d['haut']);
        $vue->afficheMenuLateral($d['lateral']);
        $vue->afficheCorps($d['corps'], 'affIndex');// TODO : je n'arrive pas à automatiser le "affIndex"
        $vue->afficheBas();
    }

}
