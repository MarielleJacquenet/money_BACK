<?php
    /*
        Template de fragment : mail signifiant le refus d'un projet
        Paramètres : $motif, le motif du refus
                     $this, le projet refusé 
    */
?>

<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf8'>
</head>
<body>
    <p>Bonjour</p>
    <p>Vous avez déposé une demande de prêt sur MONEY le <?= htmlentities(afficheDate($this->getValeur("date"))) ?>
    sous le titre <b><i><?= htmlentities($this->get("titre")) ?></i></b></p>
    <p>J'ai le regret de vous annoncer que votre projet a été refusé par les gestionnaires du site 
    pour le motif suivant :</p>
    <p><?= htmlentities($motif) ?></p>
</body>
</html>