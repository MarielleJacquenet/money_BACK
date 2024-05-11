<?php 
/*
    Template de page : affiche les détails du projet donné, avec le montant restant à financer, mis à jour toutes les 10s

    Paramètres : $projet, le projet à afficher
*/
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include "templates/fragments/head.php" ?>
    <title>Page de suivi projet MONEY</title>
</head>
<body data-idprojet="<?= $projet->getId() ?>" >

    <div class="container text-center">
        <h1>Page de suivi de votre projet</h1>

        <table>      
        <tr>
                <th class="maj1"><?= htmlentities($projet->get("titre")) ?></th>
            </tr>
            <tr>
                <td>
                        <span class="gras">Date d'acceptation du projet :</span>
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
                    <p><span class="gras">Montant total demandé :</span>
                    <?= htmlentities($projet->get("montant")) ?>€<p>
                </td>
            </tr>
            <tr>
                <td class="flex">
                    <p><span class="gras">Montant déjà financé : </span>
                    <span id="montant"> <?= $projet->montantFinance() ?></span>€<p>
                </td>
            </tr>
        </table>
    </div>
    
    <?php include "templates/fragments/footer.php" ?>
</body>
</html>