<?php

class CombatManager{

    private $_db;

    public function __construct($db){
        $this->setDb($db);
    }
    public function setDb($db){
        $this->_db = $db;
    }

    public function add(Combat $combat){
        $requete = $this->_db->prepare('INSERT INTO combat(date_combat) VALUES (:date_combat)');
        $requete->execute([
            'date_combat' => $combat->getDate_combat()
        ]);
    }

    public function delete(Combat $combat){
        $requete = $this->_db->prepare('DELETE FROM combat WHERE id_combat = :id_combat');
        $requete->execute([
            'id_combat' => $combat->getId_combat()
        ]);
    }
    public function update(Combat $combat){
        $requete = $this->_db->prepare('UPDATE combat SET date_combat = :date_combat WHERE id_combat = :id_combat');
        $requete->execute([
            'id_combat' => $combat->getId_combat(),
            'date_combat' => $combat->date_combat()
        ]);
    }

    public function get($id_combat){
        $requete = $this->_db->prepare('SELECT * FROM combat WHERE id_combat = :id_combat');
        $requete->execute([
            'id_combat' => $id_combat
        ]);
        $donnees = $requete->fetch();
        return new Combat ($donnees);
    }

    public function getList(){
        $liste = [];
        $requete = $this->_db->query('SELECT * FROM combat
        ORDER BY id_combat DESC');
        while($donnees = $requete->fetch()){
            $combat = new Combat($donnees);
            $liste[] = $combat;
        }
    return $liste;
    }

}
?>