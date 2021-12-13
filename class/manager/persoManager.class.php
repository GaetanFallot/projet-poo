<?php

class PersonnageManager{

    private $_db;

    public function __construct($db){
        $this->setDb($db);
    }
    public function setDb($db){
        $this->_db = $db;
    }

    public function add(Personnage $personnage){
        $requete = $this->_db->prepare('INSERT INTO personnage(name, token, hp, defense, str, dex, intel, cha) VALUES (:name, :token, :hp, :defense, :str, :dex, :intel, :cha)');
        $requete->execute([
            'name' => $personnage->getName(),
            'token' => $personnage->getToken(),
            'hp' => $personnage->getHp(),
            'defense' => $personnage->getDefense(),
            'str' => $personnage->getStr(),
            'dex' => $personnage->getDex(),
            'intel' => $personnage->getIntel(),
            'cha' => $personnage->getCha()
        ]);
    }

    public function delete(Personnage $id_personnage){
        $requete = $this->_db->prepare('DELETE FROM personnage WHERE id_personnage = :id_personnage');
        $requete->execute([
            'id_personnage' => $id_personnage->getId_personnage()
        ]);
    }
    public function update(Personnage $personnage){
        $requete = $this->_db->prepare('UPDATE personnage SET name = :name, token= :token,  hp = :hp, defense = :defense, str = :str, dex = :dex, intel = :intel, cha = :cha WHERE id_personnage = :id_personnage');
        $requete->execute([
            'id_personnage' => $personnage->getId_personnage(),
            'name' => $personnage->getName(),
            'token' => $personnage->getToken(),
            'hp' => $personnage->getHp(),
            'defense' => $personnage->getDefense(),
            'str' => $personnage->getStr(),
            'dex' => $personnage->getDex(),
            'intel' => $personnage->getIntel(),
            'cha' => $personnage->getCha()
        ]);
    }

    public function get($id_personnage){
        $requete = $this->_db->prepare('SELECT * FROM personnage WHERE id_personnage = :id_personnage');
        $requete->execute([
            'id_personnage' => $id_personnage
        ]);
        $donnees = $requete->fetch();
        return new Personnage ($donnees);
    }

    public function getList(){
        $liste = [];
        $requete = $this->_db->query('SELECT * FROM personnage
        ORDER BY id_personnage DESC');
        while($donnees = $requete->fetch()){
            $personnage = new Personnage($donnees);
            $liste[] = $personnage;
        }
    return $liste;
    }

    public function getListLast(){
        $liste = [];
        $requete = $this->_db->query('SELECT * FROM personnage
        ORDER BY id_personnage DESC LIMIT 5');
        while($donnees = $requete->fetch()){
            $personnage = new Personnage($donnees);
            $liste[] = $personnage;
    }
    return $liste;
    }


    public function getCount(){
            $liste = [];
            $requete = $this->_db->query('SELECT id_personnage FROM personnage');
            while($donnees = $requete->fetch()){
                $personnage = new Personnage($donnees);
                $liste[] = $personnage;
            }
        return count($liste);
    }
}

?>
