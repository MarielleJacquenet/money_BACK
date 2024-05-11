<?php 
/*
    Template de fragment : affichage d'une liste de projets donnée avec titre, description + détails porteur et liste financement

    Paramètres : $liste, la liste de projets à afficher
*/

?>

<?php if (empty($liste)) { ?>
            <h2>Aucun projet totalement financé </h2>
    <?php } else {
            foreach ($liste as $projet) { ?>
                <table class="large-80">
                    <tr>
                        <th><?= htmlentities($projet->get("titre")) ?></th>
                    </tr>
                    <tr>
                        <td>
                            <span class="gras">Description : </span>
                            <?= htmlentities($projet->get("description")) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="gras">Montant du prêt demandé : </span>
                            <?= htmlentities($projet->get("montant")) ?>€    
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="gras">Coordonnées du porteur :</span><br>
                            <?= htmlentities($projet->get("porteur")->getLibelle()) ?><br>
                            <?= htmlentities($projet->get("porteur")->get("adresse")) ?><br>
                            <?= htmlentities($projet->get("porteur")->get("telephone")) ?><br>
                            <?= htmlentities($projet->get("porteur")->get("email")) ?><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="gras">Liste des financements promis : </span><br>
                            <?php include "templates/fragments/liste_financements.php" ?>
                        </td>
                    </tr>
                </table>
            <?php }
        } ?>
