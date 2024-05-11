<?php 
/*
    Template de fragment : affichage d'un projet donné en paramètre avec titre, description, date, montant demandé, et reste à financer 
                    + bouton "participer au financement" et montant déjà promis si il existe

    Paramètres : $projet, objet projet
                 $reste, le montant restant à financer sur le projet     
*/

?>

    <table>      
    <tr>
            <th class="maj1"><?= htmlentities($projet->get("titre")) ?></th>
        </tr>
        <tr>
            <td>
                    <span class="gras">Date de dépôt du projet :</span>
                    <span class="it"><?= htmlentities(afficheDate($projet->getValeur("date"))) ?></span>
            </td>
        </tr>
        <tr>    
            <td>
                    <span class="gras">Description :</span>
                    <span class="maj1"><?= htmlentities($projet->get("description")) ?></span>
            </td>
        </tr>
        <tr>
            <td>   
                <p><span class="gras">Montant total demandé :</span>
                <?= htmlentities($projet->get("montant")) ?>€<p>
            </td>
        </tr>
        <tr>
            <td>
                <p><span class="gras">Montant restant à financer :</span>
                <?= htmlentities($projet->montantRestantAFinancer()) ?>€<p>
            </td>
        </tr>
        <tr>
            <td>
                <form action="participer.php?id=<?= $projet->getId()?>" method="post">
                    Montant : <input type="number" name="montant" min=1 max="<?= $reste ?>">€
                    <input type="submit" value="Participer à ce projet">
                </form>
                <?php 
                    $promis = $projet->montantPromis(session::get("id"));
                    if ($promis != 0){
                ?>
                    <p><span class="gras">Montant déjà promis :</span>
                    <?= htmlentities($promis) ?>€<p>
                <?php }?>
            </td>
        </tr>
    </table>