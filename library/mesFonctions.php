<?php

////////////////////////////////////////////////////////
//                 Fonctions DEBUG                    //
////////////////////////////////////////////////////////

function afRes($resultat)
{
    // Role : affiche proprement le print_r de $resultat 
    // Retour : aucun
    // Paramètre : $resultat, l'élément à afficher

    echo "<pre>";
    print_r($resultat);
    echo "</pre>";
}

////////////////////////////////////////////////////////
//                  Fonctions DATES                    //
////////////////////////////////////////////////////////

function afficheDate($date)
{
    // Role : récupère une date au format YYYY-MM-DD et la renvoie au format DD/MM/AAAA
    // Retour : date au format DD-MM-AAAA
    // Paramètre : $date, la date à traiter

    // strtotime($date) récupère la date sous un format timestamp
    // date('d/m/Y', date_format_timestamp) affiche la date sous forme DD/MM/AAAA
    return date('d/m/Y', strtotime($date));
}

////////////////////////////////////////////////////////
//                  Fonctions TESTS                   //
////////////////////////////////////////////////////////

function existe_nonvide($tabGet,$tabPost) {
    // Rôle : tester si les paramètres get et post dont le nom est donné dans les tableaux donnés existent et sont non vide
    // Retour : true si tous les paramètres existent et ont une valeur non nulle, false sinon
    // Paramètres : $tabGet, le tableau des noms d'index à tester pour $_GET["index"]
    //              $tabPost : le tableau des noms d'index à tester pour $_POST["index"]

    if (empty($tabGet) and empty($tabPost))
        return false;
    else {
        if (!empty($tabGet)) {
            //echo "get non vide<br>";
            foreach ($tabGet as $elem) {
                //echo "test index $elem<br>";

                if (!isset($_GET[$elem]) or empty($_GET[$elem]))
                    return false;
            }
        }

        if (!empty($tabPost)){
            //echo "post non vide<br>)";
            foreach ($tabPost as $elem) {
                //echo "test index $elem<br>";

                if (!isset($_POST[$elem]) or empty($_POST[$elem]))
                    return false;
            }
        }
    }
    return true;
}