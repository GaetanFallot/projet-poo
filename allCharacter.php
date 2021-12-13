<?php

require ('require.php');

$pdo = connexionBDD();
$persoManager = new PersonnageManager($pdo);
$professionManager = new ProfessionManager($pdo);

if(isset($_GET['supprimer'])){
    $id_personnage = (int)$_GET['supprimer'];
    $charactereSuppr = $persoManager->get($id_personnage);
    $persoManager->delete($charactereSuppr);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <style> img{height: 64px; width: 64px;  }</style>
    <title>RPG Character Creator</title>
</head>
<body>

<h2 class="m-1 mb-3">Bienvenue sur le site RPG Character Creator !</h2>

<?php require ('nav.php'); ?>

<h2>Liste des personnages</h2>
    <h4><?= "Il y a  ".$persoManager->getCount().' personnages au total.';?></h4>

    <table class=" mb-3 table table-dark">
        <thead>
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
        </thead>

            <?php
                $liste = $persoManager->getList();
                foreach($liste as $personnage){?>

                    <tr>
                        <td><?= $personnage->getId_personnage();?></td>
                        <td><?= $personnage->getName();?></td>
                        <td><img src="<?= $personnage->getToken();?>"/></td>
                        <td>
                        <?php 


                            // ici mettre ça dans le manager
                            $requete = $pdo->prepare('SELECT pro.professionName as professionName
                            FROM perso_profession p_p 
                            INNER JOIN profession pro 
                            ON pro.id_profession = p_p.id_profession
                            WHERE p_p.id_personnage = :id_personnage');

                            $requete->execute([
                                'id_personnage' => $personnage->getId_personnage()
                            ]);

                            while($donnees = $requete->fetch()){ 
                                echo $donnees['professionName']; 
                            } ?>
                        </td>
                        <td><?= $personnage->getHp();?></td>
                        <td><?= $personnage->getDefense();?></td>
                        <td><?= $personnage->getStr();?></td>
                        <td><?= $personnage->getDex();?></td>
                        <td><?= $personnage->getIntel();?></td>
                        <td><?= $personnage->getCha();?></td>
                        <td>
                                <button type="button" class="btn btn-primary" ><a class="text-white" href="viewMore.php?character=<?= $personnage->getId_personnage(); ?>">En savoir plus</a></button>
                                <button type="button" class="btn btn-success" ><a class="text-white" href="modifyCharacter.php?modifier=<?= $personnage->getId_personnage(); ?>">Modifier</a></button>
                                <button type="button" class="btn btn-danger" ><a class="text-white" onclick="return confirm('Etes vous sûr de vouloir supprimer cette classe ?');" href="allCharacter.php?supprimer=<?= $personnage->getId_personnage(); ?>">Supprimer</a></button>
                        </td>
                    </tr>
        
        <?php
        }
        ?>
    </table>


</body>
</html>