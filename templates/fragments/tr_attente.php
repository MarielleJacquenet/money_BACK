<?php 
/*
    Template de fragment : affichage d'un projet donné en paramètre avec titre, description et bouton pour voir les détails

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
            <a href="rechercher_details.php?id=<?= $projet->getId() ?>&action=1"><button>Détails et traitement</button></a>
        </td>
    </tr>