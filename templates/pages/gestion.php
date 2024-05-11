<?php 
/*
    Template de page : affiche un formulaire de création de profil, et des listes déroulante des membres avec des boutons "modifier" / "désactiver"

    Paramètres : $liste, la liste déroulante des membres
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

    <div class="container text-center flex center">
        <h1>Gestion des membres de MONEY</h1>

        <div class="large-70 center">
            <h2>Enregistrer un nouveau membre</h2>
                <?php include "templates/fragments/form_creation_membre.php" ?>
        </div>

        <div class="large-50 center">
            <h2>Modifier les informations d'un membre</h2>
            <div class="large-70 center">
                <?php include "templates/fragments/form_modif_membre.php" ?>
            </div>
        </div>

        <div class="large-50 center">
            <h2>Désactiver l'accès à un membre</h2>
            <div class="large-70 center">
                <?php include "templates/fragments/form_desactive_membre.php" ?>
            </div>
        </div>    
    </div>

    <?php include "templates/fragments/footer.php" ?>
</body>
</html>