<?php

class PantheonManager{

    private $_db;

    public function __construct($db){
        $this->setDb($db);
    }
    public function setDb($db){
        $this->_db = $db;
    }

    public function add(Pantheon $pantheon){
        $requete = $this->_db->prepare('INSERT INTO pantheon(name, token, hp, defense, str, dex, intel, cha) VALUES (:name, :token, :hp, :defense, :str, :dex, :intel, :cha)');
        $requete->execute([
        
            'name' => $pantheon->getName(),
            'token' => $pantheon->getToken(),
            'hp' => $pantheon->getHp(),
            'defense' => $pantheon->getDefense(),
            'str' => $pantheon->getStr(),
            'dex' => $pantheon->getDex(),
            'intel' => $pantheon->getIntel(),
            'cha' => $pantheon->getCha()
        ]);
    }

    public function delete(Pantheon $pantheon){
        $requete = $this->_db->prepare('DELETE FROM pantheon WHERE id_pantheon = :id_pantheon');
        $requete->execute([
            'id_pantheon' => $pantheon->getId_pantheon()
        ]);
    }
    public function update(Pantheon $pantheon){
        $requete = $this->_db->prepare('UPDATE pantheon SET name = :name, token= :token,  hp = :hp, defense = :defense, str = :str, dex = :dex, intel = :intel, cha = :cha, profession = :profession WHERE id_pantheon = :id_pantheon');
        $requete->execute([
            'id_personnage' => $personnage->getId_personnage(),
            'name' => $personnage->getName(),
            'token' => $personnage->getToken(),
            'hp' => $personnage->getHp(),
            'defense' => $personnage->getDefense(),
            'str' => $personnage->getStr(),
            'dex' => $personnage->getDex(),
            'intel' => $personnage->getIntel(),
            'cha' => $personnage->getCha(),
            'profession' => $pantheon->getProfession(),
        ]);
    }

    public function get($id_personnage){
        $requete = $this->_db->prepare('SELECT * FROM pantheon WHERE id_pantheon = :id_pantheon');
        $requete->execute([
            'id_pantheon' => $id_pantheon
        ]);
        $donnees = $requete->fetch();
        return new Pantheon ($donnees);
    }

    public function getList(){
        $liste = [];
        $requete = $this->_db->query('SELECT * FROM pantheon
        ORDER BY id_pantheon DESC');
        while($donnees = $requete->fetch()){
            $pantheon = new Pantheon($donnees);
            $liste[] = $pantheon;
        }
    return $liste;
    }
}

?>
