<?php 
/*
    Template de fragment : affichage d'un tableau associatif contenant le titre du projet et son montant, et d'un bouton pour voir les détails du projet

    Paramètres : $element, le tableau contenant les informations à afficher    
*/

/* Exemple d'element'
Array
        (
            [titre] => Beau jardin selon vos envies
            [description] => J'ai besoin d'un prêt pour pouvoir m'acheter du matériel (Triandine, pioche, pelle...) pour pouvoir gagner ma vie avec des travaux de jardinage.
            [total] => 750
            [statut] => valide
            [date] => 2023-05-03
            [montant] => 100
        )
*/
?>

    <tr>
        <td>
            <?= htmlentities($element["titre"]) ?>
        </td>
        <td>
            <?= htmlentities($element["montant"]) ?>
        </td>
        <td>
            <a href="rechercher_details.php?id=<?= $element["id_projet"] ?>&action=3"><button>Détails du projet</button></a>
        </td>
    </tr>