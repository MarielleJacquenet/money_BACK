<?php 
/*
    Template de fragment : affichage d'un tableau associatif contenant le titre et la description d'un projet, et le montant restant à financer + bouton détails

    Paramètres : $element
*/

?>

    <tr>
        <td>
            <?= htmlentities($element["titre"]) ?>
        </td>
        <td>
            <?= htmlentities($element["description"]) ?>
        </td>
        <td>
            <?php if (is_null($element["reste"])) 
                    $reste = $element["montant"];
                  else
                    $reste=$element["reste"]; 
                  echo htmlentities($reste);
            ?>€
        </td>
        <td>
            <a href="rechercher_details.php?id=<?= $element['id'] ?>&action=4&reste=<?=$reste?>"><button>Voir les détails et participer</button></a>
        </td>
    </tr>