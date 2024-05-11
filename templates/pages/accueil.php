<?php 
/*
    Template de page : affiche la liste donnée des derniers projets proposés, et un formulaire pour enregistrer un nouveau projet

    Paramètres : $liste, la liste des projets à afficher
*/

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include "templates/fragments/head.php" ?>
    <title>Page d'accueil - non connecté</title>
</head>
<body>
    <?php include "templates/fragments/header.php" ?>

    <div class="container text-center">
        <h1>Bienvenue sur MONEY, le site de financement de projets</h1>
        
        <h2>Derniers projets validés</h2>

        <?php if (empty($liste)) { ?>
                <h3>Aucun projet en cours </h3>
        <?php } else {?>
                <table class="large-80">
                    <tr>
                        <th>Titre</th>
                        <th>Description</th>
                    </tr>
                    <?php foreach ($liste as $projet)
                        include "templates/fragments/tr_projet_nonconnecte.php"; 
                    ?>
                </table>
        <?php } ?>

        <h2>Proposer un nouveau projet</h2>
        <div class="flex justify-center">
            <?php include "templates/fragments/form_projet.php"; ?>
        </div>
    </div>

    <?php include "templates/fragments/footer.php" ?>
</body>
</html>