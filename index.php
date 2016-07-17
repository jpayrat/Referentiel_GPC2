<?php
session_start() ;
//var_dump($_GET);
use \RefGPC\_systemClass\Autoloader;
use \RefGPC\_systemClass\Routeur;

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

//define ('SELECT_DB', 'Marc');

define ('SELECT_DB', 'Julien');

// Récupération de la page demandée par l'utilisateur
// LR/ilotControleur/action/varable2/variable2
//var_dump($_GET);
$urlGET = htmlentities($_GET['url']);
//var_dump($urlGET);
$myRouteur = new Routeur($urlGET);
$myRouteur->exec();



/**
 * Ajouté 13/07/2016 :

 * Modification de la \vue\resultIlot.php pour intégrer le fait de surligner les éléments recherché
 * Le menu latéral est maintenant appelé de l'ilotControleur et non plus de baseControleur

 **/



