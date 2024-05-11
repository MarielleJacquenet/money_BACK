<?php 
/*
    Template de fragment : affichage d'un projet donné en paramètre avec titre, description, montant financé et date de validation 

    Paramètres : $projet, le projet à afficher
*/

?>

    <tr>
        <td>
            <?= htmlentities($projet->get("titre")) ?>
        </td>
        <td>
            <?= htmlentities($projet->get("description")) ?>
        </td>
        <td>
            <?= htmlentities($projet->get("montant")) ?>
        </td>
        <td>
            <?= htmlentities(afficheDate($projet->getValeur("date"))) ?>
        </td>
    </tr>