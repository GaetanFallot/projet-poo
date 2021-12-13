<?php


class Profession{

// attributs

    private $_id_profession;
    private $_professionName;

// construteur
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



// méthodes

    
    public function getId_profession()
    {
        return $this->_id_profession;
    }


    public function setId_profession($id_profession)
    {
        $this->_id_profession = $id_profession;
    }


    public function getProfessionName()
    {
        return $this->_professionName;
    }

    public function setProfessionName($professionName)
    {
        $this->_professionName = $professionName;
    }
}

?>