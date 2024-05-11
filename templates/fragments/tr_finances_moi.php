<?php 
/*
    Template de fragment : affichage d'un projet donné en paramètre avec titre, description, montant financé et date de validation 

    Paramètres : $elem, la ligne contenant les informations à afficher
*/

?>

    <tr>
        <td>
            <?= htmlentities($elem["titre"]) ?>
        </td>
        <td>
            <?= htmlentities($elem["description"]) ?>
        </td>
        <td>
            <?= htmlentities($elem["total"]) ?>
        </td>
    </tr>