<?php 
/*
    Template de fragment : affichage d'une liste de membres sous forme de liste déroulante
    Paramètres : $liste, tableau associatif de la forme id du membre => libellé du membre
*/
?>


<?php 
    $i=0;
    foreach ($liste as $index=>$element) {
        echo "<option value='$index' ";
        if ($i==0) {
            echo "selected";
            $i++;
        }
        echo ">".htmlentities($element)."</option>";
    }
?>

