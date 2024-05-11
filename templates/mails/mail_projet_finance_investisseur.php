<?php
    /*
        Template de fragment : mail prévenant un investisseur de projet que celui-ci est totalement financé 
        Paramètres : $this, le projet 
                     $id_membre, l'id du membre contacté
    */
?>

<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf8'>
</head>
<body>
    <p>Bonjour</p>
    <p>Nous vous informons que le projet <b><i><?= htmlentities($this->get("titre")) ?></i></b> 
    pour lequel vous avez fait une promesse de don de <?= htmlentities($this->montantPromis($id_membre)) ?> 
    est désormais totalement financé.</p>
    <p>Merci de nous contacter par retour de mail pour organiser le versement des fonds.</a>
</body>
</html>