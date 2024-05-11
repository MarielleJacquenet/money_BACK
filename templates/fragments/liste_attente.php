<?php 
/*
    Template de fragment : affichage d'une liste de projets en attente de validation donnée avec titre, description et bouton pour voir les détails et gérer la validation

    Paramètres : $liste, la liste de projets à afficher
*/

?>

<table class="large-80">
    <tr>
        <th>Titre du projet</th>
        <th>Description</th>
        <th></th>
    </tr>
    <?php if (empty($liste)) { ?>
            <tr>
                <td colspan=3 class="text-center">Aucun projet en attente de validation</td>
            </tr>
    <?php } else 
             foreach ($liste as $projet)
                include "templates/fragments/tr_attente.php"; 
    ?>
</table>