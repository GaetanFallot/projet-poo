<?php

class Combat_personnageManager{

    private $_db;

    public function __construct($db){
        $this->setDb($db);
    }
    public function setDb($db){
        $this->_db = $db;
    }

    public function add(Combat_Personnage $combat_personnage){
        $requete = $this->_db->prepare('INSERT INTO combat_personnage(id_combat, id_personnage) VALUES (:id_combat , :id_personnage)');
        $requete->execute([
            'id_combat' => $combat_personnage->getId_combat(),
            'id_personnage' => $combat_personnage->getId_personnage(),
        ]);
    }
    
    public function delete(Combat_Personnage $combat_personnage){
        $requete = $this->_db->prepare('DELETE FROM combat_personnage WHERE id_combat_personnage = :id_combat_personnage');
        $requete->execute([
            'id_combat_personnage'=> $combat_personnage->getId_combat_personnage(),
        ]);
    }

    public function get($id_combat_personnage){
        $id = (int)$id;
        $requete= $this->_db->prepare('SELECT * FROM combat_personnage WHERE id_combat_personnage=:id_combat_personnage');
        $requete ->execute([
            'id_combat_personnage'=>$id_combat_personnage
        ]);
        $donnees = $requete->fetch();
        return new Combat_Personnage($donnees);
    }

    public function getList(){
        $liste = [];
        $requete = $this->_db->query('SELECT * FROM combat_personnage 
        ORDER BY id_combat_personnage DESC');
        while($donnees = $requete->fetch()){
            $combat_personnage = new Combat_Personnage($donnees);
            $liste[] = $combat_personnage;
        }
        return $liste;

    }


    public function getPersonnageCombat($id_combat){
        $liste = [];
        $requete = $this->_db->prepare('SELECT p.id_personnage as id_personnage
        FROM combat_personnage cp
        LEFT JOIN personnage p
        ON p.id_personnage = cp.id_personnage
        LEFT JOIN combat c 
        ON c.id_combat = cp.id_combat
        WHERE c.id_combat = :id_combat');
        $requete->execute([
            'id_combat' => $id_combat
        ]);
        
        while($donnees = $requete->fetch()){
            $combat_personnage = new Combat_Personnage($donnees);
            $liste[] = $donnees;
        }
        return $liste;
    }     
}

?>