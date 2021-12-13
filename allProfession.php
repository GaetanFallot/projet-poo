<?php

require ('require.php');

$pdo = connexionBDD();
$persoManager = new PersonnageManager($pdo);
$professionManager = new ProfessionManager($pdo);

if(isset($_GET['supprimer'])){
    $id_profession = (int)$_GET['supprimer'];
    $professionSuppr = $professionManager->get($id_profession);
    $professionManager->delete($professionSuppr);
}
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

<h2 class="m-1 mb-3">Bienvenue sur le catalogue des classes disponibles dans RPG Character Creator !</h2>

<?php require ('nav.php'); ?>

<h2>Liste des classes</h2>
    <h4><?= "Il y a  ".$professionManager->getCount().' classes au total.';?></h4>

    <table class=" mb-3 table table-dark">
        <thead>
            <tr class=" mb-3" >
                <th scope="col">#</th>
                <th scope="col">Classes</th>
                <th scope="col">Action</th>
            </tr>
        </thead>

            <?php
                $liste = $professionManager->getList();
                foreach($liste as $profession){?>
                    <tr>
                        <td><?= $profession->getId_profession();?></td>
                        <td><?= $profession->getProfessionName();?></td>
                        <td>
                                <button type="button" class="btn btn-success" ><a class="text-white" href="allProfession.php?modifier=<?= $profession->getId_profession(); ?>">Modifier</a></button>
                                <button type="button" class="btn btn-danger" ><a class="text-white" onclick="return confirm('Etes vous sûr de vouloir supprimer cette classe ?');" href="allProfession.php?supprimer=<?= $profession->getId_profession(); ?>">Supprimer</a></button>
                        </td>
                    </tr>
        
        <?php
        }
        ?>
    </table>
</body>
</html>