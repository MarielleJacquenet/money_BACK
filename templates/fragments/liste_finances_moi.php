<?php 
/*
    Template de fragment : affichage de la liste des projets financés par le membre connecte donnée

    Paramètres : $liste, la liste des projets à afficher (tableau associatif)
*/

?>

<table class="large-80">
    <tr>
        <th>Titre du projet</th>
        <th>Description</th>
        <th>Montant prêté</th>
    </tr>
    <?php if (empty($liste)) { ?>
            <tr>
                <td colspan=4 class="text-center">Aucun projet financé</td>
            </tr>
    <?php } else 
            foreach ($liste as $elem)
                include "templates/fragments/tr_finances_moi.php"; 
    ?>
</table>