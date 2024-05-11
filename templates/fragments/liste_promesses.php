<?php 
/*
    Template de fragment : affichage d'une liste de tableaux associatifs contenant des informations sur des promesses de financement de projet

    Paramètres : $liste, la liste
*/

?>

<table class="large-80">
    <tr>
        <th>Titre du projet</th>
        <th>Montant promis</th>
        <th></th>
    </tr>
    <?php if (empty($liste)) { ?>
            <tr>
                <td colspan=3 class="text-center">Vous n'avez aucune promesse d'investissement en cours</td>
            </tr>
    <?php } else foreach ($liste as $element)
            include "templates/fragments/tr_promesses.php"; 
    ?>
</table>