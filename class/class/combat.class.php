<?php

class Combat {

    // attribut
    private $_id_combat;
    private $_date_combat;

    // constructeur
    public function __construct($donnees){
        $this->hydrate($donnees);
    }

    // méthode hydrate 
    public function hydrate($donnees) {
        
        foreach($donnees as $key => $value) {
            $method = 'set'.ucfirst($key);

            if(method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }


    public function getId_combat(){
        return $this->_id_combat;
    }

    public function setId_combat($id_combat){
        $this->_id_combat = $id_combat;
    }

    public function getDate_combat()
    {
        return $this->_date_combat;
    }

    public function setDate_combat($date_combat)
    {
        $this->_date_combat = $date_combat;
    }
    
}
?>