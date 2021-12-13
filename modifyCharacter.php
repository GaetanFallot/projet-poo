<?php
    if(isset($_GET['modifier'])){


        require ('require.php');

    $pdo = connexionBDD();

    $professionManager = new ProfessionManager($pdo);
    $persoManager = new PersonnageManager($pdo);
    $erreurs = [];
    $succes = "";

        $id_personnage = (int)$_GET['modifier'];
        $modifyCharacter = $persoManager->get($id_personnage);
        
        if(!empty($_POST)){
            //     form
            $id_personnage = $modifyCharacter->getId_personnage();
            $name = htmlspecialchars($_POST['name']);
            $hp = (int)$_POST['hp'];
            $defense = (int)$_POST['defense'];
            $str = (int)$_POST['str'];
            $dex = (int)$_POST['dex'];
            $intel = (int)$_POST['intel'];
            $cha = (int)$_POST['cha'];
            $id_profession = htmlspecialchars($_POST['id_profession']);

            // erreur form
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
                                    //     envoi update

                                    $succes .= "L'upload est terminé";
        
                                    $modify = [
                                        'id_personnage' => $id_personnage,
                                        'name' => $name,
                                        'token' => $token,
                                        'hp' => $hp,
                                        'defense' => $defense,
                                        'str' => $str,
                                        'dex' => $dex,
                                        'intel' => $intel,
                                        'cha' => $cha,
                                    ];
                                    $modify = new Personnage($modify);
                                    $persoManager->update($modify);
        
                                    
                                    // mettre dans un manager
                                    $requete = $pdo->prepare('UPDATE perso_profession SET id_personnage = :id_personnage, id_profession = :id_profession WHERE id_personnage = :id_personnage');
                                    $requete->execute([
                                        'id_personnage' => $id_personnage,
                                        'id_profession' => $id_profession,
                                    ]);
        
        
        
                                    } else {$erreurs[] = "Une erreur est survenue lors du transfert du fichier.";}
        
                            } else { $erreurs[] = "L'extension n'est pas autorisé."; }
        
                        } else { $erreurs[] = "Le fichier est trop gros !";}
        
                    } else {$erreurs[] = "Pas de token sélectionné.";}
        
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
    <h2 class="m-1 mb-3">Bienvenue sur la modification de peronnage de RPG Character Creator !</h2>

    <?php require ('nav.php'); ?>
    <h2> Modification du personnage </h2>

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
    <form action="" method="POST" enctype="multipart/form-data">

        <div class="m-2 mb-3" >
                <label for="nom" class="form-label">Nom de votre personnage :</label>
                <input type="text" class="form-control" name="name"  value="<?= $modifyCharacter->getName();  ?>">
        </div>

        <div class="m-2 mb-3" > Changement de classe : 
            <?php 
                    // mettre dans manager
                    $requete = $pdo->prepare('SELECT pro.professionName as professionName , pro.id_profession as id_profession
                    FROM perso_profession p_p 
                    INNER JOIN profession pro 
                    ON pro.id_profession = p_p.id_profession
                    WHERE p_p.id_personnage = :id_personnage');
                    // ici ça choppe jsute la classe du gars mais pas toute
                    $requete->execute([
                    'id_personnage' => $modifyCharacter->getId_personnage()
                    ]);

                    $donnees = $requete->fetch();
                    
                    ?>
                    <select name="id_profession" class="form-select" aria-label="Default select example">
                            <option value="<?= $donnees['id_profession'];?>" selected>Votre classe actuel est : <?= $donnees['professionName']; ?></option>
                            <?php
                            $liste = $professionManager->getlist();
                            foreach($liste as $profession){?>
                            <option  value="<?= $profession->getId_profession();?>"><?= $profession->getProfessionName();?></option>
                            <?php }?>
                    </select>
            </div>

        <div class="m-2 mb-3" >
                <label for="nom" class="form-label">Token du personnage :</label>
                <input class="form-control" type="file"  name="token" value="<?= $modifyCharacter->getToken();?>">
                <div><i>Token actuel (non-modifié)</i></div>
                <img src="<?= $modifyCharacter->getToken();?>"/>
        </div>
        <div class="m-2 mb-3" >
                <label for="nom" class="form-label">Point de vie de votre personnage :</label>
                <input type="text" class="form-control" name="hp"  value="<?= $modifyCharacter->getHp();?>">
        </div>
        <div class="m-2 mb-3" >
                <label for="nom" class="form-label">Defense de votre personnage :</label>
                <input type="text" class="form-control" name="defense"  value="<?= $modifyCharacter->getDefense();  ?>">
        </div>
        <div class="m-2 mb-3" >
                <label for="nom" class="form-label">Force de votre personnage :</label>
                <input type="text" class="form-control" name="str"  value="<?= $modifyCharacter->getStr();  ?>">
        </div>
        <div class="m-2 mb-3" >
                <label for="nom" class="form-label">Dextérité de votre personnage :</label>
                <input type="text" class="form-control" name="dex"  value="<?= $modifyCharacter->getDex();  ?>">
        </div>
        <div class="m-2 mb-3" >
                <label for="nom" class="form-label">Intelligence de votre personnage :</label>
                <input type="text" class="form-control" name="intel"  value="<?= $modifyCharacter->getIntel();  ?>">
        </div>
        <div class="m-2 mb-3" >
                <label for="nom" class="form-label">Charisme de votre personnage :</label>
                <input type="text" class="form-control" name="cha"  value="<?= $modifyCharacter->getCha();  ?>">
        </div>
        <button type="submit" class="m-1 btn btn-primary">Modifier !</button>
        <button type="button" class="btn btn-success" ><a class="text-white" href="allCharacter.php">Retour à la liste de personnage !</a></button>
                                
    </form>

    </body>
    </html>
<?php
} else {
exit('out');
}
?>