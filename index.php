<?php
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

// Récupération de la page demandée par l'utilisateur
// LR/ilotControleur/action/varable2/variable2
$urlGET = htmlentities($_GET['url']);
$myRouteur = new Routeur($urlGET);
$myRouteur->exec();



/**
 * Ajouté :
 * Création des inputs par la classe formulaire pour la recherche global et ilot tapé.
 * Modification de la class ModelVue->Haut();, qui permettra d'inclure le fichier javascript qui va bien via le controleur
 *
 */




