<?php

namespace RefGPC\_controleurs\cron;

use \RefGPC\_controleurs\baseControleur;

use \RefGPC\_models\ModelVue;
use \RefGPC\_systemClass\RefGPC;

use \SplFileObject;
use \LimitIterator;
use \PDO;
class cronControleur extends baseControleur{

    public function __construct($base, $categorie) {
        parent::__construct($base, $categorie);
    }

    public function affIndex() {

        $vue = new ModelVue($this->d);
        $vue->afficheHaut($this->d['haut'], '', ''); // Le second paramètre = fichier js à inclure

        /* Etat initial : Les fichiers suivants sont sur le FTP dossier : extractGPC/T1 et extractGPC/K2
         * Agent-cda.vsc // Agent-tech.csv // Centres.csv // ftable.csv // Ilots.csv // CENUI_min.txt
         *
         * Pour chaque fichier :
         *  *** OK *** > Récupération de la date dans la table Admin_TableauBord
         *  *** OK *** > Récupération de la date du fichier
         *  *** OK *** > SI Date fichier > Date TableauBord
         *  *** OK ***     > ALORS on vide la table associé
         *  *** OK ***            on lance la mise à jour de la table associé
         *          SI la mise à jour s'est bien passé
         *          ALORS   On fait la différence de la table Tm avec la table associé
         *                  On vérifie aussi les suppression
         *                  On met à jour la table TM -> Log des modifs
         *          Si Toutes les MAJ se sont bien passé
         *          ALORS on met à jour la table TABLEAUBord avec la date du fichier.
         *  > SINON on ne lance pas de MAJ
         */

        /* Pour Midi Py, Base T1 */
        $base = 'T1';
        $chemin = PATH.'extractGPC/'.$base.'/';

        $timestamp_debut = microtime(true);
        $this->cronFichier($chemin, 'Ilots.csv', $base, 'ExtractGPC_Ilots', '5');
        $this->cronFichier($chemin, 'Centres.csv', $base, 'ExtractGPC_Centres', '13');
        $this->cronFichier($chemin, 'ftable.csv', $base, 'ExtractGPC_ActProd', '3');
        $this->cronFichier($chemin, 'Agents-cda.csv', $base, 'ExtractGPC_AgentsCDA', '9');
        $this->cronFichier($chemin, 'Agents-tech.csv', $base, 'ExtractGPC_AgentsTech', '15');
        //$this->cronFichier($chemin, 'CENUI_min.txt', $base, 'ExtractGPC_cenui', '7');
        $timestamp_fin = microtime(true);

        $difference_ms = $timestamp_fin - $timestamp_debut;
        //Exécution du script : 912.21817588806 secondes = 15,2 min
        echo '<br />Exécution du script : ' . $difference_ms . ' secondes.';

    }

    public function cronFichier($chemin, $fichier, $base, $tableExtracGPC, $nbCol){
        $dateTBIlots = $this->recupDateTableauBord($fichier,$base);
        echo 'Date TableauBord '.$fichier.' : '.$dateTBIlots['T1'].' - '.date("Y-m-d", $dateTBIlots[$base]).'<br />';

        $parseFICIlots = $this->parseFichierSPLObject($chemin.$fichier, $base);
        $dateFICIlots = $parseFICIlots->getMTime();
        echo 'Date Fichier '.$fichier.' : '.$dateFICIlots.' - '.date("Y-m-d", $dateFICIlots).'<br />';

        if($dateFICIlots > $dateTBIlots['T1']){
            $ajoutFICtoTable = $this->majTableFicGPC($fichier, $parseFICIlots, $tableExtracGPC, $nbCol);

            if($ajoutFICtoTable == 0){
                echo 'pas d\'erreur de SQL, tout est OK pour '.$fichier.' </br />';
                // Mise à jour de la table TM
                //Trouve FED et NWO a ajouter
                //SELECT `ilot` FROM `extractgpc_ilots` WHERE extractgpc_ilots.ilot NOT IN ( SELECT `iloCodeIlot` FROM `tm_ilots` )
                //INSERT INTO tm_ilots (iloCodeIlot, Ilotetc... et surtout ILOCODEBASE) SELECT `ilot` FROM `extractgpc_ilots` WHERE extractgpc_ilots.ilot NOT IN ( SELECT `iloCodeIlot` FROM `tm_ilots` )



                // trouver 12R / 81R / AP1 / TLO A supprimer
                //SELECT `iloCodeIlot` FROM `tm_ilots` WHERE iloCodeBase = 'T1' AND tm_ilots.iloCodeIlot NOT IN ( SELECT `ilot` FROM `extractgpc_ilots` )
                // Avec la mise à jour
                //UPDATE `tm_ilots` SET `iloDateSuppression` = '999' WHERE iloCodeBase = 'T1' AND tm_ilots.iloCodeIlot NOT IN ( SELECT `ilot` FROM `extractgpc_ilots` )

                
                //Modification de l'existant

            }
            else{
                echo 'il y a des erreurs dans les SQL pour '.$fichier.' </br />';
            }

        }
    }

    public function majTableFicGPC($nomFichier, $fichierParse, $tableSQL, $nbCol){
        $countErreur = 0;
        $sql = 'TRUNCATE '. $tableSQL;
        RefGPC::getDB()->queryExec($sql);

        $sql = ' INSERT INTO '.$tableSQL.' VALUES ';
        foreach($fichierParse as $key => $ligne)
        {
            if($key == 1) { }
            elseif($key % 10000 == 0)
            {
                $sql .= ';';
                try{
                    RefGPC::getDB()->queryTransaction();
                    RefGPC::getDB()->queryExec($sql);
                    RefGPC::getDB()->queryCommit();
                }
                catch (\PDOException $e) {
                    RefGPC::getDB()->queryRollBack();
                    echo "Failed: " . $e->getMessage();
                    $countErreur = $countErreur + 1;
                }
                $sql = ' INSERT INTO '.$tableSQL.' VALUES ';
            }
            elseif($fichierParse->valid() == TRUE) {$sql .= ', ';}
            else {$sql .= '; ';}

            $sql .= " (";
            for($i = 0; $i < $nbCol; $i++){
                if($nomFichier == 'CENUI_min.txt' OR $nomFichier == 'ftable.csv') {
                    // Pour accelerer le traitement de cenui et ftable
                    $sql .= "'".$ligne[$i]."'";
                }
                else{
                    if(array_key_exists($i, $ligne)){
                        $sql .= "'".$this->convert(addslashes($ligne[$i]))."'";
                    }
                    else{
                        $sql .= "''";
                    }
                }

                if($i != ($nbCol -1)){ $sql .= ' , ';}
            }
            $sql .= ")";
        }

        $sql .= ";";

        try{
            RefGPC::getDB()->queryTransaction();
            RefGPC::getDB()->queryExec($sql);
            RefGPC::getDB()->queryCommit();
        }
        catch (\PDOException $e) {
            RefGPC::getDB()->queryRollBack();
            echo "Failed: " . $e->getMessage();
            $countErreur = $countErreur + 1;
        }

        return $countErreur;

    }


    public function parseFichierSPLObject($fichier, $base ){
        $parseFIC = new SplFileObject($fichier, 'r');
        $parseFIC->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
        $parseFIC->setCsvControl(';');
        $parseFIC = new LimitIterator($parseFIC, 1);

        return $parseFIC;
    }

    public function recupDateTableauBord($fichier, $base){
        $sql = "SELECT ".$base." FROM Admin_TableauBord WHERE nomFichier = '".$fichier."'; ";
        $dateTB = RefGPC::getDB()->queryOne($sql);

        return $dateTB;
    }




    public function cron(){



        $vue->afficheAdminCorps($this->d['corps'], 'affIndexAdmin');



        /* test sur la création de la requete sql en venant d'un csv */
        /*
         * Il faudra mettre en place le test de la date de creation du fichier et la mise à jour
         * de la table qui contient si les fichier son à jour ou non exemple
         * fichier  LR  MP
         * ftable   ok  Nok
         * Filot    ok  ok
         * etc etc...
        */

        /**** Parse du fichier sur le serveur et affichage *****/






        //$csv2 = new SplFileObject(PATH.'extractGPC/CENUI_K2_min.txt', 'r');
        //$csv = new SplFileObject(PATH.'extractGPC/Ilots.csv', 'r');
        $csv2 = new SplFileObject(PATH.'extractGPC/ftable.csv', 'r');
        $csv2->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
        $csv2->setCsvControl(';');
        $csv2 = new LimitIterator($csv2, 1);

        /* recuperation de la date de modif */
        $datemodif = $csv2->getMTime();
        echo date('Y-m-d', $datemodif);
        /* fin recup date, script fonctionne OK */

/*
        $sql = ' START TRANSACTION;
        INSERT INTO tableTEST VALUES 
         ';

        foreach($csv2 as $key => $ligne)
        {
            //echo 'Ligne '.$key.' : '.$ligne[0].' // '.$this->convert($ligne[1]).'<br />';
            if($key == 1) { }
            elseif($key % 10000 == 0)
            {
                $sql .= '; COMMIT;';
                RefGPC::getDB()->queryExec($sql);

                $sql = 'START TRANSACTION; INSERT INTO tableTEST VALUES ';
            }
            elseif($csv2->valid() == TRUE) {$sql .= ', ';}
            else {$sql .= '; ';}


            $sql .= " ('".$ligne[0]."' , '".$ligne[1]."' , '".$ligne[2]."' , '".$ligne[3]."' , '".$ligne[4]."' , '".$ligne[5]."' , '".$ligne[6]."')";



        }

        $sql .= ' ; COMMIT; ';

//echo $sql;

        RefGPC::getDB()->queryExec($sql);

        /* Fin du test */


        $vue->afficheBas();
    }


    public function convert($chaine) {
        $convArray = array(
            chr(230) => 'µ',
            chr(130) => 'é',
            chr(138) => 'è',
            chr(140) => 'î',
            chr(230) => 'µ',  // ok
            chr(130) => 'é',  // ok
            chr(138) => 'è',  // ok

            chr(132) => 'ä',  // ok
            chr(131) => 'â',  // ok
            //chr(???) => '@',  // code pas trouvé
            chr(137) => 'ë',  // 137
            chr(136) => 'ê',  // 136
            chr(139) => 'ï',  // 139
            chr(140) => 'î',  // 140

            chr(147) => 'ô',  // 147
            chr(148) => 'ö',  // 148
            chr(150) => 'û',  // 150
            chr(129) => 'ü',  // 129

            chr(133) => 'à',  // 133
            chr(151) => 'ù',  // 151
            chr(156) => '£',  // 156
            chr(245) => '§',   // 245
            chr(198) => 'ã',  //  198
            //	chr(164) => 'ñ',  // 164 ñ : nok code pas trouvé
            chr(228) => 'õ',  // ok
        );
        foreach ($convArray as $key => $value)
        {
            $chaine = str_replace ($key, $value, $chaine);
        }

        return $chaine;
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
