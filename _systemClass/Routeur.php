<?php

namespace RefGPC\_systemClass;

class Routeur {

    // nom du controleur par defaut en attendant d'avoir une véritable page d'accueil
    const DEF_CONTROLLERNAME = 'ilotControleur';
    // action par defaut en attendant d'avoir une véritable page d'accueil
    const DEF_ACTIONNAME = 'affIndex';
    
    // ui par defaut
    const DEF_UI = 'MP';

    private $knownControllers = array(
        'baseControleur',
        'ilotControleur',
        'centreControleur',
        'techControleur',
        ); // liste des controlleurs connus, A maintenir à jour !!!

    /* index tableau $paramsUrl
     * 0 : ui LR ou MP
     * 1 : controleur
     * 2 : methode
     * 3+ : autres parametres
     */
    protected $paramsUrl = array();

    public function __construct($url) {
        // traite les données de l'url
        $this->paramsUrl = $this->traiteURL($url);
    }

    protected function traiteURL($url) {
        $pageAsk = (string) filter_input(INPUT_GET, 'url');
        $pageAsk = rtrim($pageAsk, '/');
        $pageAsk = explode('/', $pageAsk); // séparation des éléments de l'url
        //var_dump($pageAsk);
        // Calcul de la base choisie LR ou MP
        if (isset($pageAsk[0])) {
            if (!preg_match('#[A-Z]{2}#', $pageAsk[0])) { $pageAsk[0] = 'MP';  /* ui par défaut */ }
            else { $pageAsk[0] = $pageAsk[0] == 'LR' ? 'LR' : 'MP'; }
        }
        else { $pageAsk[0] = self::DEF_UI; /* ui par défaut */ }

        // Calcul du controleur : $controllerName = $pageAsk[1].'Controleur';
        if (!isset($pageAsk[1])) {
            die("Erreur 404 : url mal formée : pas de controleur");
        }
        // echo "pag 1 ".$pageAsk[1];
        if (!$this->controllerExists($pageAsk[1])) { 
            // TODO :
            // le controleur choisi est inconnu : 
            // utiliser un controleur d'erreur et afficher 404
            echo '<br />Attention le controleur {'. $pageAsk[1] . '} n\'existe pas, redirection vers '.self::DEF_CONTROLLERNAME.' .';
            
            $pageAsk[1] = self::DEF_CONTROLLERNAME; 
        }

        // Calcul de la method du controleur à utiliser
        $pageAsk[2] = isset($pageAsk[2]) ? $pageAsk[2] : self::DEF_ACTIONNAME;
        return $pageAsk;
    }

    private function controllerExists($name) { return in_array($name, $this->knownControllers); }

    public function exec() {
        $controller = $this->createController();
        if (method_exists($controller, $this->methodName())) {
            $data = $this->paramsUrl;
            //unset($data[1]);
            //unset($data[2]);
            //var_dump($data);
            call_user_func_array(array($controller, $this->methodName()), $this->paramsUrl);
        }
        else {
            // TODO: creer le controller des erreur et renvoyer sur erreur 404
            echo '<br /> ERREUR 404';
            var_dump($this->paramsUrl);
            throw new RefGpcException('Dispatch::exec() : methode ['.$this->methodName().'] inexistante !');
        }
    }

    public function createController() {
        $name = '\\RefGPC\\_controleurs\\' . $this->controllerName();
        //echo '<br />Dispatch::createController : Classe appele : [' . $name.']';
        // \RefGPC\_controleurs
        return new $name();
    }

    public function methodName() { return $this->paramsUrl[2]; }
    public function controllerName() { return $this->paramsUrl[1]; }

    //Pas utilisé ici ...
    public function baseName() { return $this->paramsUrl[0]; }
    public function addController($name) { $this->knownControllers[] = $name; }

}