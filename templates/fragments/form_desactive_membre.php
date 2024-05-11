<?php 
/*
    Template de fragment : formulaire pour choisir un membre grâce à une liste déroulante avec appel au controleur desactiver
    Paramètres : $liste, tableau associatif de la forme id du membre => libellé du membre
*/

?>

<form action="desactiver.php" method="post">
    <label> <p class="gras">Choisir un membre : </p>   
        <select name="id">
            <?php include "templates/fragments/liste_deroulante_membres.php" ?>
        </select>
    </label>
    <input type="submit" value="Désactiver ce membre"><br>
</form>
