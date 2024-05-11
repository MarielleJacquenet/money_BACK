<?php 
/*
    Template de page : affiche un message de confirmation ou non de l'enregistrement d'un projet et un bouton de retour à l'accueil de l'application

    Paramètres : $res, l'id du projet créé ou 0 si pb lors de la création
*/
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include "templates/fragments/head.php" ?>
    <title>Résultat demande d'enregistrement</title>
</head>
<body>
    <?php include "templates/fragments/header.php" ?>

    <h1>Résultat de votre demande d'enregistrement</h1>
    <?php if ($res != 0) { 
            echo "<p>Projet enregistré, en attente de validation par un des gestionnaires de l'application</p>";
            echo "<p>La réponse vous parviendra prochainement par mail</p>";
          }
          else 
            echo "Erreur lors de la saisie, le projet n'a pas pu être enregistré"; 
    ?> 

    <a href="index.php"><button>Retour à la page d'accueil</button></a>
     
    <?php include "templates/fragments/footer.php" ?>
</body>
</html>