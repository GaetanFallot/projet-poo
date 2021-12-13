<?php

require ('require.php');

$pdo = connexionBDD();
$persoManager = new PersonnageManager($pdo);
$professionManager = new ProfessionManager($pdo);
$erreurs = [];
$succes = '';

if(!empty($_POST)){
    $professionName = htmlspecialchars($_POST['professionName']);

    if(!$professionName){
        $erreurs[] = 'Veuillez indiquer un nom de classe !';
    }

    if(!$erreurs){
        $succes = "Classe créée !";
        $envoiProfession = ['professionName' => $professionName];
        $envoiProfession = new Profession($envoiProfession);

        $envoiProfession = $professionManager->add($envoiProfession);
    }
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

<h2 class="m-1 mb-3">Bienvenue sur la création de classe de RPG Character Maker !</h2>

<?php require ('nav.php'); ?>
    <!-- <h3 class="m-1 mb-3"><//?= "Il y a ".$manager->getCount().' personnages';?></h3> -->

    <?php
    if($erreurs) {
        foreach($erreurs as $e)
        echo '<div class="alert alert-danger" role="alert">'.$e.'</div>'; 
    }
    if($succes) {
        echo '<div class="alert alert-success" role="alert">'.$succes.'</div>';
    }
    ?>

<form action="" method="POST">
    <div class="m-2 mb-3" >
        <label for="nom" class="form-label">Nom la classe :</label>
        <input type="text" class="form-control" id="nom" name="professionName">
    </div>
    <button type="submit" class="m-1 btn btn-primary">Créer la classe</button>
</form>


</body>
</html>