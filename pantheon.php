<?php

require ('require.php');

$pdo = connexionBDD();
$persoManager = new PersonnageManager($pdo);
$professionManager = new ProfessionManager($pdo);
$pantheon = new PantheonManager($pdo);

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

<h2>RIP</h2>
    <!-- <h4><?//= "Il y a  ".$persoManager->getCount().' personnages au total.';?></h4> -->

    <table class=" mb-3 table table-dark">
        <thead>
            <tr class=" mb-3" >
                <th scope="col">Nom</th>
                <th scope="col">Token</th>
                <th scope="col">Defense</th>
                <th scope="col">Force</th>
                <th scope="col">Dextérité</th>
                <th scope="col">Intelligence</th>
                <th scope="col">Charisme</th>
            </tr>
        </thead>

            <?php
                $liste = $pantheon->getList();
                foreach($liste as $personnage){?>

                    <tr>
                        <td><?= $personnage->getName();?></td>
                        <td><img src="<?= $personnage->getToken();?>"/></td>
                        <td><?= $personnage->getDefense();?></td>
                        <td><?= $personnage->getStr();?></td>
                        <td><?= $personnage->getDex();?></td>
                        <td><?= $personnage->getIntel();?></td>
                        <td><?= $personnage->getCha();?></td>
                    </tr>
        
        <?php
        }
        ?>
    </table>


</body>
</html>