<?php

require ('require.php');

$pdo = connexionBDD();
$persoManager = new PersonnageManager($pdo);
$professionManager = new ProfessionManager($pdo);

$listeCarousel = $persoManager->getListLast();

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
    <!-- <h3 class="m-1 mb-3"><//?= "Il y a ".$manager->getCount().' personnages';?></h3> -->
    <div class="carousel-container d-flex justify-content-center ">
        
      <button class='btn btn-secondary' onclick="previousSlide()">&#10094;</button>
        <?php foreach($listeCarousel as $carousel){ ?>
            <div class='slide '>
                <div class="card " style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $carousel->getName(); ?></h5>
                        <h6 class="card-subtitle ">Image du personnage :<img src="<?= $carousel->getToken(); ?>" /></h6>
                        <p class="card-text">Point de vie : <?= $carousel->getHp(); ?></p>
                        <p class="card-text">Défense : <?= $carousel->getDefense(); ?></p>
                        <p class="card-text">Force : <?= $carousel->getStr(); ?></p>
                        <p class="card-text">Dextérité : <?= $carousel->getDex(); ?></p>
                        <p class="card-text">Intelligence : <?= $carousel->getIntel(); ?></p>
                        <p class="card-text">Charisme : <?= $carousel->getCha(); ?></p>
                    </div>
                </div>
            </div>
        <?php
            }
        ?>
              <!-- bouton suivant et precedent-->
      <button class='btn btn-secondary' onclick="nextSlide()">&#10095;</button>

      <!-- <div class='dots'>
        <span class='dot' onclick='showSlide(1)'></span>
        <span class='dot' onclick='showSlide(2)'></span>
        <span class='dot' onclick='showSlide(3)'></span>
      </div> -->
    </div>

    


    <script src="https://releases.jquery.com/git/jquery-3.x-git.min.js"></script>
    <script src="index.js"></script>
</body>
</html>