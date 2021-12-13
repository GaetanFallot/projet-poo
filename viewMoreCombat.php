<?php
    if(isset($_GET['combat'])){
    require ('require.php');

    
    $id_combat = (int)$_GET['combat'];

    $pdo = connexionBDD();
    $professionManager = new ProfessionManager($pdo);
    $persoManager = new PersonnageManager($pdo);
    $combatManager = new CombatManager($pdo);
    $combat_personnageManager = new Combat_personnageManager($pdo);
    $pantheon = new PantheonManager($pdo);
    $erreurs = [];
    $succes = "";
    $combat = $combatManager->get($id_combat);
    
    $listePersoCombat = $combat_personnageManager->getPersonnageCombat($id_combat);
    $nbrPersoCbt = count($listePersoCombat);


    if(!empty($_POST)){
        $id_personnage = (int)$_POST['id_personnage'];

        if(!$id_personnage){
            $erreurs[] = "Choissisez un joueur";
        }
        if($nbrPersoCbt >= 2  ){
            $erreurs[] = "Le nombre maximum de personnage pour ce duel à été atteins.";
        }
        if(!$erreurs){
            $succes .= "Joueur ajouté.";
            $envoiPerso = [
                'id_personnage' => $id_personnage,
                'id_combat' => $id_combat
            ];
            $envoiPerso = new Combat_personnage($envoiPerso);
            $envoiPerso = $combat_personnageManager->add($envoiPerso);
        }
    }



    foreach($listePersoCombat as $persoCombat){
        $persoCombattant = $persoManager->get($persoCombat['id_personnage']);
        
    }


    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style> img{height: 64px; width: 64px;  }</style>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">

        <title>RPG Character Creator</title>
    </head>
    <body>

    <h2 class="m-1 mb-3">Bienvenue sur l'aperçu du combat !</h2>

    <?php require ('nav.php'); ?>

        <div class="carousel-container d-flex justify-content-center ">
        
              <div class='slide '>
                  <div class="card " style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title"><?= $combat->getDate_combat(); ?></h5>

                            <p class="card-text">Combat numéro : <?= $combat->getId_combat(); ?></p>
                        </div>
                        
                    <button class="m-1 btn btn-danger"><a class="text-white" href="fight.php?combat=<?= $id_combat ?>">Lancer le combat</a></button>
                    <button class="m-1 btn btn-primary"><a class="text-white" href="allCombat.php">Retour à la liste des combats</a></button>
                  </div>
              </div>
      </div>
      <table class=" mb-3 table table-dark">
            <tr class=" mb-3" >
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Token</th>
                <th scope="col">Classe</th>
                <th scope="col">Point de vie</th>
                <th scope="col">Defense</th>
                <th scope="col">Force</th>
                <th scope="col">Dextérité</th>
                <th scope="col">Intelligence</th>
                <th scope="col">Charisme</th>
                <th scope="col">Action</th>
            </tr>
                    <?php
                    foreach($listePersoCombat as $persoCombat){
                        $persoCombattant = $persoManager->get($persoCombat['id_personnage']);
                        ?>

                        <tr>
                            <td><?= $persoCombattant->getId_personnage();?></td>
                            <td><?= $persoCombattant->getName();?></td>
                            <td><img src="<?= $persoCombattant->getToken();?>"/></td>
                            <td>
                            <?php
                                // ici mettre ça dans le manager
                                $requete = $pdo->prepare('SELECT pro.professionName as professionName
                                FROM perso_profession p_p 
                                INNER JOIN profession pro 
                                ON pro.id_profession = p_p.id_profession
                                WHERE p_p.id_personnage = :id_personnage');

                                $requete->execute([
                                    'id_personnage' => $persoCombattant->getId_personnage()
                                ]);

                                while($donnees = $requete->fetch()){ 
                                    echo $donnees['professionName']; 
                                } ?>
                            </td>
                            <td><?= $persoCombattant->getHp();?></td>
                            <td><?= $persoCombattant->getDefense();?></td>
                            <td><?= $persoCombattant->getStr();?></td>
                            <td><?= $persoCombattant->getDex();?></td>
                            <td><?= $persoCombattant->getIntel();?></td>
                            <td><?= $persoCombattant->getCha();?></td>
                            <td>
                            <button type="button" class="btn btn-danger" ><a class="text-white" onclick="return confirm('Etes vous sûr de vouloir supprimer ce personage ?');" href="viewMoreCombat.php?combat=<?= $id_combat ?>&supprimer=<?= $persoCombattant->getId_personnage(); ?>">Supprimer</a></button>
                            </td>
                        </tr>

                <?php
                }    
                ?>
        </table>



      <?php
            if($erreurs){
                foreach($erreurs as $e){
                    echo '<div class="alert alert-danger" role="alert">'.$e.'</div>'; 
                }
            }
            if($succes) {
                echo '<div class="alert alert-success" role="alert">'.$succes.'</div>';
            }

        ?>
      <form action="" method='POST'>

            <div class="m-1 mb-3" >
                <label for="nbr" class="form-label">Joueur inscription  :</label>
                <br/>
                <?php
                    
                    $listePerso = $persoManager->getList();
                    foreach($listePerso as $perso){
                        
                        if(isset($perso)){?>
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="inlineCheckbox1" name="id_personnage" value="<?= $perso->getId_personnage();?>" checked>
                            <label class="form-check-label" for="inlineCheckbox1"><?= $perso->getName();?></label>
                        </div>
                        <?php  }
                }
                ?>
            </div>

        <button type="submit" class="m-1 btn btn-primary">Ajout du joueur !</button>

    </form>

    </body>

<?php 
} else {
    exit('out');
}
?>
    </html>