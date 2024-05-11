<?php 
/*
    Template de fragment : affichage d'un projet donné en paramètre avec titre, description, date, montant demandé, montant promis

    Paramètres : $projet, objet projet
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
                <p><span class="gras">Montant promis :</span>
                <?= htmlentities($projet->montantPromis(session::get("id"))) ?>€<p>
            </td>
        </tr>
    </table>