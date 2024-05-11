<?php 
/*
    Template de page : affiche la liste donnée en fonction de l'action donnée, et le header correspondant à une connexion comme membre

    Paramètres : $liste, la liste des financements à afficher
                 $action, le type de liste envoyé 
                        3 => Membre - Mes financements promis
                        4 => Membre - Projets en cours avec montant restant
                        5 => Membre - Tous les projets complètement financés 
                        6 => Membre - Mes projets complètement financés
*/

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include "templates/fragments/head.php" ?>
    <title>Page d'accueil membre MONEY</title>
</head>
<body>
    <?php include "templates/fragments/header.php" ?>

    <div class="container text-center">
      <?php if ($action == 3) {
            echo "<h1>Mes promesses de financement</h1>";
            include "templates/fragments/liste_promesses.php";
          }
          elseif ($action == 4) {
            echo "<h1>Projets en cours avec le reste à financer</h1>";
            include "templates/fragments/liste_encours_reste.php";
          } 
          elseif ($action == 5) {
            echo "<h1>Tous les projets complètement financés</h1>";
            include "templates/fragments/liste_finances.php";
          }
          elseif ($action == 6) {
            echo "<h1>Mes projets complètement financés</h1>";
            include "templates/fragments/liste_finances_moi.php";
          }

      ?>
    </div>

    <?php include "templates/fragments/footer.php" ?>
</body>
</html>