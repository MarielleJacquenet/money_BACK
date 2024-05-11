<?php 
/*
    Template de fragment : formulaire pour saisie d'un membre grâce à une liste déroulante avec appel au controleur modifier_profil
    Paramètres : $liste, tableau associatif de la forme id du membre => libellé du membre
*/

?>

<form action="afficher_form_profil.php" method="post">
    <label> <p class="gras">Choisir un membre : </p>   
        <select name="id">
            <?php include "templates/fragments/liste_deroulante_membres.php" ?>
        </select>
    </label>
    <input type="submit" value="Modifier le profil de ce membre"><br>
</form>