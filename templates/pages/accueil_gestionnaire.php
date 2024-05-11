<?php 
/*
    Template de page : affiche la liste donnée en fonction de l'action donnée, et le header correspondant à une connexion comme gestionnaire

    Paramètres : $liste, la liste des projets à afficher
                 $action, le type de liste envoyé 
                        1 => Gestionnaire - Projets en attente de validation
                        2 => Gestionnaire - Liste des projets acceptés avec détails et liste financement            
                 
*/

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include "templates/fragments/head.php" ?>
    <title>Page d'accueil gestionnaire</title>
</head>
<body>
    <?php include "templates/fragments/header.php" ?>

    <div class="container text-center">
      <div class="text-center">
        <?php if ($action == 1) {
                echo "<h1>Liste des projets en attente de validation</h1>";
                include "templates/fragments/liste_attente.php";
              }
              elseif ($action == 2) {
                echo "<h1>Liste des projets acceptés avec liste des financements</h1>";
                include "templates/fragments/liste_acceptes_financement.php";
              }
        ?>
      </div>
    </div>

    <?php include "templates/fragments/footer.php" ?>
</body>
</html>