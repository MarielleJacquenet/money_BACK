<?php 
/*
    Template de fragment : affichage de la liste de tous les projets financés donnée avec titre, description et montant

    Paramètres : $liste, la liste des projets à afficher
*/

?>

<table class="large-80">
    <tr>
        <th>Titre du projet</th>
        <th>Description</th>
        <th>Montant prêté</th>
        <th>Date d'acceptation</th>
    </tr>
    <?php if (empty($liste)) { ?>
            <tr>
                <td colspan=4 class="text-center">Aucun projet financé</td>
            </tr>
    <?php } else 
            foreach ($liste as $projet)
                include "templates/fragments/tr_finances.php"; 
    ?>
</table>