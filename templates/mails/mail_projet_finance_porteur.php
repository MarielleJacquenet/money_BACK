<?php
    /*
        Template de fragment : mail prévenant un porteur de projet que celui-ci est totalement financé 
        Paramètres : $this, le projet 
    */
?>

<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf8'>
</head>
<body>
    <p>Bonjour</p>
    <p>Nous vous informons que les investisseurs de MONEY sont prêts à totalement financer votre 
    projet <b><i><?= htmlentities($this->get("titre")) ?></i></b></p> 
    <p>Merci de nous contacter par retour de mail pour organiser le versement des fonds.</a>
</body>
</html>