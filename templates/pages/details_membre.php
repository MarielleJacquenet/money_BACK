<?php 
/*
    Template de page : affiche les détails du projet donné en fonction de l'action donnée

    Paramètres : $projet, le projet à afficher
                 $action, entier qui indique quels détails on veut afficher
                    3 => détails du projet +  montant financé par le membre connecté
                    4 => détails du projet + reste à financer + bouton "participer" ou montant financé par le memebre connecté
                 $reste, optionnel, attendu pour $action = 4, le montant restant à financer sur le projet     
   
*/
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include "templates/fragments/head.php" ?>
    <title>Détails du projet</title>
</head>
<body>
    <?php include "templates/fragments/header.php" ?>

    <div class="container text-center">
        <h1>Détails du projet</h1>
        <?php if ($action == 3)  { 
                include "templates/fragments/details_projet.php";
            } 
            elseif ($action == 4) {
                include "templates/fragments/details_projet_reste.php";
            }
        ?>
    </div>

    <?php include "templates/fragments/footer.php" ?>
</body>
</html>