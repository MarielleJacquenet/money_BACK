<?php 
/*
    Template de fragment : affichage d'une liste de financements promis pour un projet

    Paramètres : $projet, le projet pour lequel on veut une liste de financements
*/

?>

<?php $liste = $projet->listeFinancements() ;
    if (empty($liste))
        echo "Aucun investisseur pour l'instant";
    else {
        foreach ($liste as $financement) { 
            echo htmlentities($financement->get("membre")->getLibelle())." ".htmlentities($financement->get("montant"))."€<br>";
        }
    if ($projet->get("statut") =="finance")
        echo "<p class='maj green'>Ce projet a été complètement financé</p>";    
    }
 ?>