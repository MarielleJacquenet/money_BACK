<?php 
/*
    Template de fragment : affichage d'une liste de projets en recherche de financement avec reste à financer

    Paramètres : $liste, la liste à afficher (tableau associatif)
*/

// penser bouton "participer" dans détails

?>

<table class="large-80">
    <tr>
        <th>Titre du projet</th>
        <th>Description</th>
        <th>Reste à financer</th>
        <th></th>
    </tr>
    <?php if (empty($liste)) {?>
            <tr>
                <td colspan=4 class="text-center">Aucun projet en recherche de financement pour l'instant</td>
            </tr>
    <?php } else
        foreach ($liste as $element)
            include "templates/fragments/tr_encours_reste.php"; 
    ?>
</table>