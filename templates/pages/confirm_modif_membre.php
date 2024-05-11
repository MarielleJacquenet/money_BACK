<?php 
/*
    Template de page : affiche un message de confirmation ou non de la modification d'un profil et un bouton de retour à l'accueil de l'application

    Paramètres : $message, message à afficher
*/
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include "templates/fragments/head.php" ?>
    <title>Résultat modification de profil</title>
</head>
<body>
    <?php include "templates/fragments/header.php" ?>

    <h1>Résultat de votre demande de modification de profil</h1>
   
    <p><?= $message ?></p>

    <a href='gerer_membres.php'><button>Retourner sur le page de gestion des membres</button></a>
     
    <?php include "templates/fragments/footer.php" ?>
</body>
</html>