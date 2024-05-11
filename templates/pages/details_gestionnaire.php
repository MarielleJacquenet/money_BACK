<?php 
/*
    Template de page : affiche les détails du projet donné, avec les coordonnées du porteur et des boutons "accepter" et "refuser"

    Paramètres : $projet, le projet à afficher
*/
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include "templates/fragments/head.php" ?>
    <title>Détails du projet en attente de validation</title>
</head>
<body>
    <?php include "templates/fragments/header.php" ?>

    <div class="container text-center">
        <h1>Projet en attente de validation</h1>
        <table>      
            <tr>
                <th class="maj1"><?= htmlentities($projet->get("titre")) ?></th>
            </tr>
            <tr>
                <td>
                        <span class="gras">Date de dépôt du projet :</span>
                        <span class="it"><?= htmlentities(afficheDate($projet->getValeur("date"))) ?></span>
                </td>
            </tr>
            <tr>    
                <td>
                        <span class="gras">Description :</span>
                        <span class="maj1"><?= htmlentities($projet->get("description")) ?></span>
                </td>
            </tr>
            <tr>
                <td>   
                    <p><span class="gras">Montant demandé :</span>
                    <?= htmlentities($projet->get("montant")) ?>€<p>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="gras">Coordonnées du porteur :</span><br>
                    <?= htmlentities($projet->get("porteur")->getLibelle()) ?><br>
                    <?= htmlentities($projet->get("porteur")->get("adresse")) ?><br>
                    <?= htmlentities($projet->get("porteur")->get("telephone")) ?><br>
                    <?= htmlentities($projet->get("porteur")->get("email")) ?><br>
                </td>
            </tr>
            <tr>
                <td>
                    <form action="accepter_projet.php?id=<?= $projet->getId()?>" method="post">
                        <label> Modifier la description : <br>
                            <textarea name="description" cols="30" rows="6"><?= $projet->get("description")?></textarea>
                        </label>
                        <input type="submit" value="Accepter ce projet">
                    </form>
                </td>
            </tr>
            <tr>
                <td>
                    <form action="refuser_projet.php?id=<?= $projet->getId()?>" method="post">
                        <textarea name="motif" cols="30" rows="6">Indiquez le motif du refus</textarea>
                        <input type="submit" value="Refuser ce projet">
                    </form>
                </td>
            </tr>
        </table>
    </div>
    
    <?php include "templates/fragments/footer.php" ?>
</body>
</html>