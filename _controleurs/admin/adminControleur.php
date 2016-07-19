<?php

namespace RefGPC\_controleurs\admin;

use \RefGPC\_controleurs\baseControleur;

use \RefGPC\_models\ModelVue;
use \RefGPC\_models\Formulaire;
use \RefGPC\_systemClass\RefGPC;

class adminControleur extends baseControleur{
    
    public function __construct($base) {
        parent::__construct($base);
    }

    public function affIndex() {

        $verifLogin = parent::verifLogin();
        if($verifLogin == false){
            $this->affFormulaireLogin();
        }
        else
        { // true
            $this->affProfilLogin();
        }
    }

    public function affFormulaireLogin($placeholderNom='CUID', $placeholderMdp='Mot de passe', $msg=''){

        $colorPlaceHolderNom = $placeholderNom == 'CUID' ? '' : 'incorrect'; // Permet la coloration en rouge du placeholder
        $colorPlaceHolderMdp = $placeholderMdp == 'Mot de passe' ? '' : 'incorrect'; // Permet la coloration en rouge du placeholder

        $form = new Formulaire($this->codeBase());
        $this->d['corps']['inputNom'] = $form->input('nom', '30','28',$placeholderNom, $colorPlaceHolderNom  );
        $this->d['corps']['inputPass'] = $form->inputPasswd('pass','30','28',$placeholderMdp, $colorPlaceHolderMdp );

        $vue = new ModelVue($this->d);
        $vue->afficheHaut($this->d['haut'], ''); // Le second paramètre = fichier js à inclure
        $vue->afficheMenuLateralAdmin();
        $vue->afficheAdminCorps($this->d['corps'], 'affIndexAdmin');
        $vue->afficheBas();
    }
    
    public function connexion(){

        //Initialisation des variables :
        $PlaceHolderNom = '';
        $PlaceHolderMdp = '';

        $antiSPAM1 = $this->testGetPOST(); // On test si le formulaire a bien été envoyé, evite les spams basiques par mail et e-mail
        if($antiSPAM1 == true)
        {
            $token = 0; // Permet de savoir si on traite la demande ou si on affiche le formulaire avec une erreur

            // On récupère les varaibles du formulaires, traitement htmlentities
            $nom = $this->get_POST('nom');
            $mdp = $this->get_POST('pass');

            // On analyse les variables du formulaire
            if(empty($nom)) {
                $PlaceHolderNom = 'Vous devez saisir un nom !';
                $token = $token + 1;
            }

            if(empty($mdp)) {
                $PlaceHolderMdp = 'Vous devez saisir un mot de passe !';
                $token = $token + 1;
            }

            if($token == 0) // Toutes les vérifications sont OK
            {
                $sql = "SELECT id,nom,pass,email FROM t_comptes WHERE nom='".$nom."' AND pass='".$mdp."'";
                $res = RefGPC::getDB()->queryCount($sql);
                if($res == 0)
                {
                    $msg['type'] = 'Nok';
                    $msg['titre'] = 'Attention !';
                    $msg['msg'] = "Aucunes données ne correspond à votre saisie ! <br /> Veuillez recommencer ou contacter l'administrateur de ce site.";

                    $vue = new ModelVue($this->d);
                    $vue->afficheHaut($this->d['haut'], ''); // Le second paramètre = fichier js à inclure
                    $vue->afficheMenuLateralAdmin();
                    $vue->afficheMsg($msg, 'affMsg');// TODO : je n'arrive pas à automatiser le "affIndex"
                    $vue->afficheBas();
                }
                else
                {
                    $result = RefGPC::getDB()->queryOne($sql);


                    //on créer la session
                    $_SESSION['nom'] = $result['nom'];
                    $_SESSION['pass'] = $result['pass'];
                    $_SESSION['mail'] = $result['email'];

                    //on redirige
                    $msg['type'] = 'ok';
                    $msg['titre'] = 'Félicitation !';

                    if($_SESSION['nom'] == 'EMPI6446' )
                    {
                        $msg['msg'] = 'Connexion réussie. Redirection en cours... <script type="text/javascript"> window.setTimeout("location=(\''.WEBPATH.'LR/ilot\');",2000) </script>';
                    }
                    else
                    {
                        $msg['msg'] = 'Connexion réussie. Redirection en cours... <script type="text/javascript"> window.setTimeout("location=(\''.WEBPATH.'MP/ilot\');",2000) </script>';
                    }

                    $vue = new ModelVue($this->d);
                    $vue->afficheHaut($this->d['haut'], ''); // Le second paramètre = fichier js à inclure
                    $vue->afficheMenuLateralAdmin();
                   $vue->afficheMsg($msg, 'affMsg');// TODO : je n'arrive pas à automatiser le "affIndex"
                    $vue->afficheBas();
                }
            }
            else {
                // Toutes les vérifications ne sont pas Ok
                // On affiche le formulaire

                $this->affFormulaireLogin($PlaceHolderNom, $PlaceHolderMdp);
            }



        }
        else{
            // On ne traite pas le formulaire, les mails on été modifiés -- SPAM
        }





        /* Récupération des variables envoyées
         * function, est-ce que le login est bon ?
         * function, initialiser les variables de session
         *
        */

        //$vue = new ModelVue($this->d);
        //$vue->afficheBas();
    }

    public function deconnexion()
    {
        // On le deconecte en supprimant simplement les sessions pseudo et mdp
        unset($_SESSION['nom']);
        unset($_SESSION['pass']);
        unset($_SESSION['mail']);

        $msg['type'] = 'ok';
        $msg['titre'] = 'Déconnexion réussie !';
        $msg['msg'] = 'Vous avez bien été déconnecté, à très bientôt ! Redirection en cours... <script type="text/javascript"> window.setTimeout("location=(\''.WEBPATH.'AD/admin\');",3000) </script>';


        // On affiche la page de connexion
        $vue = new ModelVue($this->d);
        $vue->afficheHaut($this->d['haut'], ''); // Le second paramètre = fichier js à inclure
        $vue->afficheMenuLateralAdmin();
        $vue->afficheMsg($msg, 'affMsg');// TODO : je n'arrive pas à automatiser le "affIndex"
        $vue->afficheBas();

    }

    public function affProfilLogin()
    {
        $vue = new ModelVue($this->d);
        $vue->afficheHaut($this->d['haut'], ''); // Le second paramètre = fichier js à inclure
        $vue->afficheMenuLateralAdmin();
        $vue->afficheAdminCorps($this->d['corps'], 'affProfilAdmin');// TODO : je n'arrive pas à automatiser le "affIndex"
        $vue->afficheBas();
    }


    public function testGetPOST()
    {
        return (isset($_POST['Envoyer']) AND isset($_POST['mail']) AND $_POST['mail'] == NULL AND isset($_POST['e-mail']) AND $_POST['e-mail'] == NULL);
      }

    public function get_POST($paramName){
        // A mettre dans un model Admin
        return isset($_POST[$paramName]) ? htmlentities($_POST[$paramName]) : '';
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
