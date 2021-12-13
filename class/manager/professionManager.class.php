<?php

class ProfessionManager{
    private $_db;

    public function __construct($db){
        $this->setDb($db);
    }
    public function setDb($db){
        $this->_db = $db;
    }

    public function add(Profession $profession){
        $requete = $this->_db->prepare('INSERT INTO profession(professionName) VALUES (:professionName)');
        $requete->execute([
            'professionName' => $profession->getProfessionName()
        ]);
    }

    public function delete(Profession $profession){
        $requete = $this->_db->prepare('DELETE FROM profession WHERE id_profession = :id_profession');
        $requete->execute([
            'id_profession' => $profession->getId_profession()
        ]);
    }
    public function update(Profession $profession){
        $requete = $this->_db->prepare('UPDATE profession SET professionName = :professionName WHERE id_profession = :id_profession');
        $requete->execute([
            'id_profession' => $profession->getId_profession(),
            'professionName' => $profession->getProfessionName()
        ]);
    }

    public function get($id_profession){
        $requete = $this->_db->prepare('SELECT * FROM profession WHERE id_profession = :id_profession');
        $requete->execute([
            'id_profession' => $id_profession
        ]);
        $donnees = $requete->fetch();
        return new Profession ($donnees);
    }

    public function getList(){
        $liste = [];
        $requete = $this->_db->query('SELECT * FROM profession
        ORDER BY id_profession DESC');
        while($donnees = $requete->fetch()){
            $profession = new Profession($donnees);
            $liste[] = $profession;
        }
    return $liste;
    }

    
    public function getCount(){
            $liste = [];
            $requete = $this->_db->query('SELECT id_profession FROM profession');
            while($donnees = $requete->fetch()){
                $profession = new Profession($donnees);
                $liste[] = $profession;
            }
        return count($liste);
    }
}

?>
