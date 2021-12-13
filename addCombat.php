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

if(!empty($_POST)){
    $date_combat = htmlspecialchars($_POST['date_combat']);

    if(!$date_combat){
        $erreurs[] = "Veuillez choisir une date pour le combat.";
    }

    if(!$erreurs){

        $envoiCombat = [
            'date_combat' => $date_combat,
        ];
        $envoiCombat = new Combat($envoiCombat);
        var_dump($envoiCombat);
        $combatManager->add($envoiCombat);
        
        $succes .= "Le combat est crée !";
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

<h2 class="m-1 mb-3">Bienvenue sur la création de peronnage de RPG Character Creator !</h2>

<?php require ('nav.php'); ?>

<h3> Création de combat ! </h3>

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

    <form action="" method='POST' >
        <div class="m-1 mb-3" >
            <label for="nom" class="form-label">Choississez une date pour votre combat</label>
            <input type="date" class="form-control" name="date_combat">
        </div>

        <button type="submit" class="m-1 btn btn-primary">Créer le combat !</button>

    </form>

</body>
</html>