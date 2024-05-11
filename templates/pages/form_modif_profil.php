<?php 
/*
    Template de page : affiche un formulaire de modification du profil prérempli avec les données contenues dans l'objet membre donné

    Paramètres : $membre, le membre à modifier
*/
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include "templates/fragments/head.php" ?>
    <title></title>
</head>
<body>
    <?php include "templates/fragments/header.php" ?>

    <div class="container">
        <div class="large-70 text-center  center">
        <h1>Modifier un profil</h1>
        <form action="modifier_profil.php?id=<?=$membre->getId() ?>" method="post">
            <fieldset>
                <div class="flex justify-between">
                <div class="large-30 text-end">
                        <label> Pseudo</label>
                </div>
                <div class="large-70">
                        <input type="text" name="pseudo" value=<?= $membre->get("pseudo")?>>
                </div>    
                <div class="large-30 text-end">
                    <label> Email</label>
                    </div>
                    <div class="large-70">
                        <input type="email" name="email" value=<?= $membre->get("email")?>>
                    </div>    
                    <div class="large-30 text-end">
                        <label> Mot de passe </label>
                    </div>
                    <div class="large-70">
                        <input type="password" name="mp">
                    </div>    
                    <div class="large-30 text-end">
                        <label> Répétez le mot de passe</label>
                    </div>
                    <div class="large-70">
                        <input type="password" name="mp2">
                    </div>    
                    <div class="large-30 text-end">
                        <label> Nom</label>
                    </div>
                    <div class="large-70">
                    <input type="text" name="nom" value=<?= $membre->get("nom")?>>
                    </div>    
                    <div class="large-30 text-end">
                        <label>Prénom</label>
                    </div>
                    <div class="large-70">
                        <input type="text" name="prenom" value=<?= $membre->get("prenom")?>>
                    </div>    
                    <div class="large-30 text-end">
                        <label> Code postal </label>
                    </div>    
                    <div class="large-70">
                        <input type="text" name="cp" value=<?= $membre->get("cp")?>>
                    </div>    
                    <div class="large-30 text-end">
                        <label> Rôle </label>
                    </div>
                    <div class="large-70">
                        <select name="role">
                        <option value="membre" 
                                <?php if ($membre->get("role") == "membre") 
                                    echo " selected ";?>
                            >Membre simple</option>
                            <option value="gestionnaire"
                                <?php if ($membre->get("role") == "gestionnaire") 
                                    echo " selected ";?>
                            >Gestionnaire</option>
                        </select>  
                    </div>   
                </div>    
            </fieldset>   
            <fieldset>
                    <input type="submit" value="Modifier">
            </fieldset> 
        </form>
        </div>
    </div>

    
    <?php include "templates/fragments/footer.php" ?>
</body>
</html>