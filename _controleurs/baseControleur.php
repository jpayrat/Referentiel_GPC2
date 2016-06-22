<?php
namespace RefGPC\_controleurs;
/**
 * Description of defautControleur
 * classe de base des controleurs
 * @author Marc
 */
class baseControleur {
    
    
    var $vars = array();

    public function __construct() {
      //  echo "<br />baseControleur CTOR";
    }

    
    public function affIndex() {
        echo "baseControleur :: affIndex  test </br>";
    }
    
    
    /**
     * Charge les données du modele : 
     * @param $modelName : nom du modele
     * @param $param : parametre du modele
     */
    function loadModel($modelName, $param) {
        
        // require file
        $createName = 'RefGPC\\_models\\'.$modelName;
        $this->$modelName = new $createName($param);
    }

    /**
     * Ajoute les données au tableau des variables.
     * @param type $data
     */
    function setData($data) {
        $this->var = array_merge($this->vars, $data);
    }

    /**
     * envoie les données à la vue.
     */
    function render($filename) {
        global $dirVues;
        
        extract($this->vars);
        var_dump($this->vars);
        require($dirVues.$filename);
        
    }

}
