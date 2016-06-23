<?php

namespace RefGPC\_systemClass;

class Routeur {

    // nom du controleur par defaut en attendant d'avoir une véritable page d'accueil
    const DEFCONTROLLERNAME = 'ilot\ilotControleur';
    // action par defaut en attendant d'avoir une véritable page d'accueil
    const DEFACTIONNAME = 'affIndex';

    private $knownControllers = array();
    private function initControleurs(){
        $this->knownControllers['base'] = '';
        $this->knownControllers['centre'] = '';
        $this->knownControllers['ilot'] = 'ilot';
        $this->knownControllers['ilotAjax'] = 'ilot';
    }
    // liste des controlleurs connus, A maintenir à jour !!!

    
    /* index tableau $paramsUrl
     * 0 : ui LR ou MP
     * 1 : controleur
     * 2 : methode
     * 3+ : autres parametres
     */
    protected $paramsUrl = array();

    public function __construct($url) {
        // traite les données de l'url
       // echo '<br> Routeur::__construct url = ['.$url.']';
       // var_dump($url);
       
        $this->initControleurs();
        
        // var_dump($this->knownControllers);
         
        $data = $this->readURL($url);
        //var_dump($data);
        $this->paramsUrl['base']        = $data[0];
        $this->paramsUrl['controleur']  = $data[1];
        $this->paramsUrl['methode']     = $data[2];
        
        // lecture des autres parametres dans $this->paramsUrl
       $this->readParam(array_slice($data, 3));
       // var_dump($this->paramsUrl);
    }

    /**
     * Récuperation des parametres base, controleur, methode
     * @param type $url : donnée du $_GET
     * @return type array()
     */
    protected function readURL($url) {
        $pageAsk = (string) filter_input(INPUT_GET, 'url');
        $pageAsk = rtrim($pageAsk, '/');
        $pageAsk = explode('/', $pageAsk); // séparation des éléments de l'url
           // var_dump($pageAsk[0]);  
        // Calcul de la base choisie LR ou MP
        if (isset($pageAsk[0])) {
            if (!preg_match('#[A-Z]{2}#', $pageAsk[0])) { $pageAsk[0] = 'MP';  /* ui par défaut */ }
            else { $pageAsk[0] = $pageAsk[0] == 'LR' ? 'LR' : 'MP'; }
        }
        else { $pageAsk[0] = 'MP'; /* ui par défaut */ }

        if (isset($pageAsk[1])){
            //echo '<br /> ['.$pageAsk[1].']';
            //var_dump($this->knownControllers);
            //echo '-> rep :  ['.$this->knownControllers[$pageAsk[1]].']';
            if (isset($this->knownControllers[$pageAsk[1]])) {
               // 
                $pageAsk[1] = $this->knownControllers[$pageAsk[1]].'\\'.$pageAsk[1]. 'Controleur';
                //echo '<br /> ciontrolleur ['.$pageAsk[1].']';
                
               //var_dump($pageAsk[1]);
            }
            else {
                echo '<br />Controleur ['.$pageAsk[1].'] non trouvé : controleur par defaut !'; // pour debug
               $pageAsk[1] = self::DEFCONTROLLERNAME;  
            }
        }
        else {
            $pageAsk[1] = self::DEFCONTROLLERNAME;  
        }
        // Calcul de la method du controleur à utiliser
        $pageAsk[2] = isset($pageAsk[2]) ? $pageAsk[2] : self::DEFACTIONNAME;
        return $pageAsk;
    }

    /**
     * Lecture des autres parametres.
     * Mémorise le nom des parametres
     * Ajoute les parametres non nommés dans l'ordre ouù ils arrivent.
     * @param type $data données du $_GET sans les données base,controleur,methode
     */
    protected function readParam($data) {
       // var_dump($data);
        foreach($data as  $value) {
            $posEgal = strpos($value, '=');
            // parametre non nommé
            if ($posEgal === FALSE) { $this->paramsUrl[] = $value; }
            //parametre nommé
            else {
                $parts = explode('=', $value);
                $this->paramsUrl[$parts[0]] = $parts[1]; 
            }
        }
    }
    
    
    private function controllerExists($name) { return in_array($name, $this->knownControllers); }

    
    /**
     * Appel de la methode du controleur et passage des parametres
     * dans la methode
     * @throws \Exception
     */
    public function exec() {
       // $this->dump();
        $controller = $this->createController();
        if (method_exists($controller, $this->methodName())) {
            $data = $this->paramsUrl;
            //unset($data[1]);
            //unset($data[2]);
           // var_dump($data);
            //var_dump($this->paramsUrl);
            call_user_func_array(array($controller, $this->methodName()), array($this->paramsUrl));
        }
        else {
            // TODO: creer le controller des erreur et renvoyer sur erreur 404
            echo '<br /> ERREUR 404 -> dumping params :';
            var_dump($this->paramsUrl);
            throw new \Exception('Dispatch::exec() : methode ['.$this->methodName().'] inexistante !');
        }
    }

    public function createController() {
        $name = '\\RefGPC\\_controleurs\\' . $this->controllerName();
        echo '<br />Dispatch::createController : Classe appelée : [' . $name.']';
        // \RefGPC\_controleurs
        return new $name();
    }

    public function methodName()     { return $this->paramsUrl['methode'];    }
    public function controllerName() { return $this->paramsUrl['controleur']; }

    public function dump() {
        echo '<pre>'.__METHOD__;
        var_dump($this->paramsUrl);
        echo '</pre>';
    }
}