<?php

require ('require.php');

$pdo = connexionBDD();

$professionManager = new ProfessionManager($pdo);
$persoManager = new PersonnageManager($pdo);
$erreurs = [];
$succes = "";

if(!empty($_POST)){
    $name = htmlspecialchars($_POST['name']);
    $hp = (int)$_POST['hp'];
    $defense = (int)$_POST['defense'];
    $str = (int)$_POST['str'];
    $dex = (int)$_POST['dex'];
    $intel = (int)$_POST['intel'];
    $cha = (int)$_POST['cha'];
    $id_profession = (int)$_POST['id_profession'];

    if(strlen($name) < 3 || strlen($name) > 32){
        $erreurs[] = "Veuillez rentrer un nom entre 3 et 32 charactères.";
    }
    if($hp < 1 || $hp > 100){
        $erreurs[] = "Veuillez rentrez une jauge de vie entre 1 et 100 pv.";
    }
    if($defense < 1 || $defense > 30){
        $erreurs[] = "Veuillez rentrez une defense entre 1 et 30.";
    }
    if($str < 1 || $str > 20){
        $erreurs[] = "Veuillez rentrez une force entre 1 et 20.";
    }
    if($dex < 1 || $dex > 20){
        $erreurs[] = "Veuillez rentrez une dexterité entre 1 et 20.";
    }

    if($intel < 1 || $intel > 20){
        $erreurs[] = "Veuillez rentrez une inteligence entre 1 et 20.";
    }
    if($cha < 1 || $cha > 20){
        $erreurs[] = "Veuillez rentrez un charisme entre 1 et 20.";
    }
    
    if(!$erreurs) {
        if (!empty($_FILES)){
            if($_FILES["token"]['error'] === 0) {
                if($_FILES["token"]['size'] < 1000000) {
        
                    $infoFichier = pathInfo($_FILES["token"]['name']);
                    
                    $extension = $infoFichier['extension'];
                    
                    $nomSansExtension = $infoFichier['filename'];
                    
                    $tabExtensionsAutorisees = ['php','jpg','jpeg','gif','png'];
                    
                    if(in_array($extension, $tabExtensionsAutorisees)){
        
                        $destination = "image/".$nomSansExtension.time().".".$extension;
                        $res = move_uploaded_file($_FILES["token"]['tmp_name'], $destination);
                        $token = htmlspecialchars($destination);

                      
                        if($res) {
                            $succes .= "L'upload est terminé";

                            $envoiCharacter = [
                                'name' => $name,
                                'token' => $token,
                                'hp' => $hp,
                                'defense' => $defense,
                                'str' => $str,
                                'dex' => $dex,
                                'intel' => $intel,
                                'cha' => $cha
                            ];
                            $envoiCharacter = new Personnage($envoiCharacter);
                            $persoManager->add($envoiCharacter);

                            $id_personnage =  $pdo->lastInsertId();
                            
                            $requete = $pdo->prepare('INSERT INTO perso_profession (id_personnage, id_profession) VALUES (:id_personnage, :id_profession)');
                            $requete->execute([
                                'id_personnage' => $id_personnage,
                                'id_profession' => $id_profession,
                            ]);



                            } else {$erreurs[] = "Une erreur est survenue lors du transfert du fichier.";}

                    } else { $erreurs[] = "L'extension n'est pas autorisé."; }

                } else { $erreurs[] = "Le fichier est trop gros !";}

            } else {$erreurs[] = "une erreur est survenue.";}

        } else {$erreurs[] = "Vous n'avez pas renseigné de fichier.";}

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
    <!-- <h3 class="m-1 mb-3"><//?= "Il y a ".$manager->getCount().' personnages';?></h3> -->

<h3> Création de personnage ! </h3>

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

    <form action="" method='POST' enctype="multipart/form-data">
        <div class="m-1 mb-3" >
            <label for="nom" class="form-label">Nom de votre personnage</label>
            <input type="text" class="form-control" id="nom" name="name">
        </div>


        <div class="m-1 mb-3" >
            <label for="formFile" class="form-label">Image de votre personnage</label>
            <input class="form-control" type="file" id="formFile" name="token">
        </div>


        <div class="m-1 mb-3" >
            <label for="nom" class="form-label">Point de vie de votre personnage</label>
            <input type="number" class="form-control" name="hp">
        </div>
        <div class="m-1 mb-3" >
            <label for="nom" class="form-label">Défense de votre personnage</label>
            <input type="number" class="form-control" name="defense">
        </div>
        <div class="m-1 mb-3" >
            <label for="nom" class="form-label">Force de votre personnage</label>
            <input type="number" class="form-control" name="str">
        </div>
        <div class="m-1 mb-3" >
            <label for="nom" class="form-label">Dextérité de votre personnage</label>
            <input type="number" class="form-control" name="dex">
        </div>
        <div class="m-1 mb-3" >
            <label for="nom" class="form-label">Intelligence de votre personnage</label>
            <input type="number" class="form-control" name="intel">
        </div>
        <div class="m-1 mb-3" >
            <label for="nom" class="form-label">Charisme de votre personnage</label>
            <input type="number" class="form-control" name="cha">
        </div>

        <div class="m-1 mb-3" >
            <label for="nbr" class="form-label">Classe de votre personnage</label>
            <br/>
            <?php 
                $liste = $professionManager->getlist();
                foreach($liste as $profession){?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="inlineCheckbox1" name="id_profession" value="<?= $profession->getId_profession();?>" checked>
                        <label class="form-check-label" for="inlineCheckbox1"><?= $profession->getProfessionName();?></label>
                    </div>
            <?php    
            }
            ?>
        </div>
        <button type="submit" class="m-1 btn btn-primary">Créer le personnage !</button>

    </form>

</body>
</html>