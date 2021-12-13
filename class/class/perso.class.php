<?php

class Personnage {

    // attribut
    private $_id_personnage;
    private $_name;
    private $_token;
    private $_hp;
    private $_defense;
    private $_str;
    private $_dex;
    private $_intel;
    private $_cha;

    // constructeur
    public function __construct($donnees){
        $this->hydrate($donnees);
    }

    // méthode hydrate 
    public function hydrate($donnees) {
        if($donnees){
        foreach($donnees as $key => $value) {
            $method = 'set'.ucfirst($key);

            if(method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
}

    // méthode

    public function getId_personnage(){
        return $this->_id_personnage;
    }

    public function setId_personnage($id_personnage){
        $this->_id_personnage = $id_personnage;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setName($name)
    {
        $this->_name = $name;
    }


    public function getToken()
    {
        return $this->_token;
    }


    public function setToken($token)
    {
        $this->_token = $token;
    }


    public function getHp()
    {
        return $this->_hp;
    }


    public function setHp($hp)
    {
        $this->_hp = $hp;
    }


    public function getDefense()
    {
        return $this->_defense;
    }


    public function setDefense($defense)
    {
        $this->_defense = $defense;
    }


    public function getStr()
    {
        return $this->_str;
    }


    public function setStr($str)
    {
        $this->_str = $str;
    }


    public function getDex()
    {
        return $this->_dex;
    }


    public function setDex($dex)
    {
        $this->_dex = $dex;
    }


    public function getIntel()
    {
        return $this->_intel;
    }


    public function setIntel($intel)
    {
        $this->_intel = $intel;
    }


    public function getCha()
    {
        return $this->_cha;
    }


    public function setCha($cha)
    {
        $this->_cha = $cha;
    }
}




?>
