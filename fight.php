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

    

    if(!empty($_POST)){
        $id_personnage = (int)$_POST['id_personnage'];

        if(!$id_personnage){
            $erreurs[] = "Veuillez slectionner une cible pour votre attaque.";
        }

        if(!$erreurs){

            $cibleAttaque = $persoManager->get($id_personnage);
            $hpCible = $cibleAttaque->getHp();
            $hpCible -= 20;
            if($hpCible <= 0){
                
                $succes .= " L'adversaire est mort. Combat terminé.";

                $mort = [
                    'name' => $cibleAttaque->getName(),
                    'token' => $cibleAttaque->getToken(),
                    'defense' => $cibleAttaque->getDefense(),
                    'hp' => $cibleAttaque->getHp(),
                    'str' => $cibleAttaque->getStr(),
                    'intel' => $cibleAttaque->getIntel(),
                    'dex' => $cibleAttaque->getDex(),
                    'cha' => $cibleAttaque->getCha(),
                ];
                $mort = new Pantheon($mort);
                $pantheon->add($mort);

                $persoManager -> delete($cibleAttaque);

            }

            $cibleAttaque -> setHp($hpCible);
            $persoManager -> update($cibleAttaque);

            $succes .= "L'attaque a été effectué avec succès.";
        }
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


        <h2 class="m-1 mb-3">C'est l'heure du duel !</h2>

        <?php require ('nav.php'); ?>



    <div class="d-flex justify-content-center">
        <?php
            foreach($listePersoCombat as $persoCombat){
                $persoCombattant = $persoManager->get($persoCombat['id_personnage']);
        ?>

                <div class="card " style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $persoCombattant->getName(); ?></h5>
                        <h6 class="card-subtitle ">Image du personnage :<img src="<?= $persoCombattant->getToken(); ?>" /></h6>
                        <p class="card-text">Point de vie : <?= $persoCombattant->getHp(); ?></p>
                        <p class="card-text">Défense : <?= $persoCombattant->getDefense(); ?></p>
                        <p class="card-text">Force : <?= $persoCombattant->getStr(); ?></p>
                        <p class="card-text">Dextérité : <?= $persoCombattant->getDex(); ?></p>
                        <p class="card-text">Intelligence : <?= $persoCombattant->getIntel(); ?></p>
                        <p class="card-text">Charisme : <?= $persoCombattant->getCha(); ?></p>
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
                        </div>

                        <form method="POST" action ="">
                            <div class="m-1 mb-3" >
                                    <label for="nbr" class="form-label">Attaquer:</label>
                                    <br/>
                                    <?php
                                        foreach($listePersoCombat as $perso){
                                            $perso = $persoManager->get($perso['id_personnage']);
                                            ?>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="inlineCheckbox1" name="id_personnage" value="<?= $perso->getId_personnage();?>" checked>
                                                <label class="form-check-label" for="inlineCheckbox1"><?= $perso->getName();?></label>
                                            </div>
                                    <?php  
                                    }
                                    ?>
                            </div>

                            <button type="submit" class="m-1 btn btn-primary">Attaque !</button>
                        </form>
                </div>
        <?php 
            }
        ?>
        

    </div>

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

</body>

<?php 
    } else {
        exit('out');
    }
?>
</html>