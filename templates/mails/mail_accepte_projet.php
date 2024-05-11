<?php
    /*
        Template de fragment : mail signifiant l'acceptation d'un projet
        Paramètres : $this, le projet accepté
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
    <p>J'ai le plaisir de vous annoncer que votre projet a été accepté par les gestionnaires du site</p>
    <p><a href='http://examen.mjacquenet.mywebecom.ovh/suivre_projet.php?id=<?= $this->getId() ?>&code=<?= $this->get("code") ?>' > 
    Suivez l'évolution du financement de votre projet en suivant ce lien</a>
</body>
</html>