<?php
use \RefGPC\_systemClass\Autoloader;
use \RefGPC\_systemClass\Routeur;
//use \RefGPC\_systemClass\Connexion;
use \RefGPC\_systemClass\RefGPC;

//require 'F:/Programmes/wamp/www/Referentiel_GPC/_controleurs/baseControleur.php';

// Autoloader de classes
require("_systemClass/Autoloader.php");
Autoloader::register(); // On pourrait enlever \RefGPC\_systemClass\ si on met un [use \RefGPC\_systemClass\Autoloader;] en début de fichier

// Definition des chemins
define ('WEBPATH', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
define ('PATH', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));


// Définition des dossiers du MVC
define ('CONTROLEURS_PATH', PATH.'_controleurs/');
define ('MODELS_PATH', PATH.'_models/');
define ('VUES_PATH', PATH.'_vues/');

// Définition de la connexion à la BD
define ('SELECT_DB', 'marclocal'); // selectionne la base de données

$connexion = new \RefGPC\_systemClass\Connexion(); // creation de l'utilisateur
$connexion->addDB('marclocal', 'root', '', 'referentiel-gpc'); // identifiants 
$connexion->addDB('juju','referentiel-gpc_pprod_si', 'referenti_si_dbo', 'PswcS1li');
RefGPC::connect($connexion); // determine la connexion a la base
// la base peut être appelée avec RefGPC::getDB()
// mais on peut aussi faire $connexion->getDB()
// J'ai ajoute un utilisateur dans RefGPC pour garder le code existant.



// Récupération de la page demandée par l'utilisateur
// LR/ilotControleur/action/varable2/variable2
$urlGET = htmlentities($_GET['url']);
$myRouteur = new Routeur($urlGET);
$myRouteur->exec();




















/*
die("myDispacher");
// Format de l'URL : referentielGPC.com/BaseLR-MP/Controleur/methode
$pageAsk = htmlentities($_GET['url']); // Récup sécurisé de l'url
$pageAsk = explode('/', $pageAsk); // séparation des éléments de l'url



    // Calcul de la base choisie LR ou MP
    if(preg_match('#[A-Z]{2}#', $pageAsk[0])) {
        if($pageAsk[0] == 'LR'){ $ui = 'LR'; }
        else { $ui = 'MP'; }
    }
    else {
        $ui = 'MP'; // ui par défaut
    }
    echo '<br /> Ui sélectionnée : '.$ui;

    // Calcul du controleur
    //$controllerName = $pageAsk[1].'Controleur';
    $controllerName = isset($pageAsk[1]) ? $pageAsk[1].'Controleur' : 'ilotControleur'; // En attendant d'avoir une page d'accueil ...
    echo '<br /> Controleur sélectionné : '.$controllerName;

    // Calcul de la method du controleur à utiliser
    $methodName = isset($pageAsk[2]) ? $pageAsk[2] : 'affIndex';
    echo '<br /> Méthode sélectionnée : '.$methodName;
    echo '<br />';
/*
    //Lister tout les controleur existant;
    Dispatch::addController('ilotControleur');
    Dispatch::addController('centreControleur');


$controller = Dispatch::createController($controllerName);
echo '<br /> creation controleur: ['.$controller. ']';

*/
// Opérations sur la session
/*


// Appels des controleurs
switch ($pageAsk)
{
    case "ilotAffForm";
        require($dirControleurs."ilotControleur-old.php");
    break;

    case "ilotResForm";
        echo 'plop'; 
        require($dirControleurs."rechercheFormePPros_C.php");
    break;

    default : 
        require($dirControleurs."ilotControleur-old.php"); // Page index par defaut
}*/