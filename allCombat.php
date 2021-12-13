<?php

require ('require.php');

$pdo = connexionBDD();
$professionManager = new ProfessionManager($pdo);
$persoManager = new PersonnageManager($pdo);
$combatManager = new CombatManager($pdo);
$combat_personnageManager = new Combat_personnageManager($pdo);
$pantheon = new PantheonManager($pdo);
$erreurs = [];
$succes = "";

if(isset($_GET['supprimer'])){
    $id_combat = (int)$_GET['supprimer'];
    $combatSuppr = $combatManager->get($id_combat);
    $combatManager->delete($combatSuppr);
}


$liste = $combatManager->getList();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    
    <title>RPG Character Creator</title>
</head>
<body>

<h2 class="m-1 mb-3">Bienvenue sur le site RPG Character Creator !</h2>

<?php require ('nav.php'); ?>

<h2>Liste des combats</h2>

    <table class=" mb-3 table table-dark">
        <thead>
            <tr class=" mb-3" >
                <th scope="col">Date du combat</th>
                <th scope="col">Action</th>

            </tr>
        </thead>

            <?php
                foreach($liste as $combat){?>

                    <tr>
                        <td><?= $combat->getDate_combat();?></td>
                        

                        <td>
                                <button type="button" class="btn btn-primary" ><a class="text-white" href="viewMoreCombat.php?combat=<?= $combat->getId_combat(); ?>">En savoir plus</a></button>
                                <button type="button" class="btn btn-danger" ><a class="text-white" onclick="return confirm('Etes vous sûr de vouloir supprimer ce combat ?');" href="allCombat.php?supprimer=<?= $combat->getId_combat(); ?>">Supprimer</a></button>
                        </td>
                    </tr>
        
        <?php
        }
        ?>
    </table>


</body>
</html>