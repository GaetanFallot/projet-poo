<?php


class Combat_Personnage{

// attributs

    private $_id_combat_personnage;
    private $_id_combat;
    private $_id_personnage;

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
    
    public function getId_combat_personnage()
    {
        return $this->_id_combat_personnage;
    }


    public function setId_combat_personnage($id_combat_personnage)
    {
        $this->_id_combat_personnage = $id_combat_personnage;
    }
    
    public function getId_personnage()
    {
        return $this->_id_personnage;
    }


    public function setId_personnage($id_personnage)
    { 
        $this->_id_personnage = $id_personnage;
    }

    public function getId_combat()
    {
        return $this->_id_combat;
    }


    public function setId_combat($id_combat)
    {
        $this->_id_combat = $id_combat;
    }


}
?>