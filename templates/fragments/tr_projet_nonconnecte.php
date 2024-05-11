<?php 
/*
    Template de fragment : affichage d'un projet donné en paramètre avec titre et description

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
    </tr>


