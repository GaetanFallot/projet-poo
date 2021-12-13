<?php
    if(isset($_GET['character'])){

        $id_personnage = htmlspecialchars($_GET['character']);
        require ('require.php');
        $pdo = connexionBDD();
        $persoManager = new PersonnageManager($pdo);
        
        $personnage = $persoManager -> get($id_personnage);
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

    <h2 class="m-1 mb-3">Bienvenue sur l'aperçu des personnages !</h2>

    <?php require ('nav.php'); ?>

        <div class="carousel-container d-flex justify-content-center ">
        
              <div class='slide '>
                  <div class="card " style="width: 18rem;">
                      <div class="card-body">
                          <h5 class="card-title"><?= $personnage->getName(); ?></h5>
                          <h6 class="card-subtitle ">Image du personnage :<img src="<?= $personnage->getToken(); ?>" /></h6>
                          <p class="card-text">Point de vie : <?= $personnage->getHp(); ?></p>
                          <p class="card-text">Défense : <?= $personnage->getDefense(); ?></p>
                          <p class="card-text">Force : <?= $personnage->getStr(); ?></p>
                          <p class="card-text">Dextérité : <?= $personnage->getDex(); ?></p>
                          <p class="card-text">Intelligence : <?= $personnage->getIntel(); ?></p>
                          <p class="card-text">Charisme : <?= $personnage->getCha(); ?></p>
                      </div>
                                
                    <button class="m-1 btn btn-primary"><a class="text-white" href="allCharacter.php">Retour à la liste des peronnages</a></button>
                  </div>
              </div>
      </div>


    </body>
<?php 
} else {
    exit('out');
}
?>
    </html>