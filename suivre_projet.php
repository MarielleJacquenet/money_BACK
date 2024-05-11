<?php
/*
    URL controleur : récupérer l'enregistrement projet dans la BD correspondant à l'id et au code donnés, et l'afficher 
    
    Paramètres : GET id, l'id du projet, 
                     code, le code perso attribué au porteur du projet
*/

/********************/
/*  INITIALISATIONS */
/********************/
include "library/init.php";

/**********************************************/
/* VERIFICATION / RECUPERATION DES PARAMETRES */
/**********************************************/

if (isset($_GET['id']) and isset($_GET['code']) and !empty($_GET['id']) and !empty($_GET['code'])) {
    $id = $_GET['id'];
    $code = $_GET['code'];

/*************************************/
/* RECUPERATION DES INFOS A AFFICHER */
/*      TRAITEMENTS SUR LA BD        */
/*************************************/
    // chercher un enregistrement contenant l'id et le code dans la BD
    $projet = new projet();
    $res = $projet->objetCriteres(["id"=>$id, "code"=>$code]);

    // si on l'a trouvé, on peut afficher les détails
    if ($res) {

/*************/
/* AFFICHAGE */
/*************/
        // template de page : "details_porteur.php"
        // paramètres à passer : $projet, objet projet à afficher
        include "templates/pages/details_porteur.php";
    }
}
else
    echo "ERREUR - Cette page n'existe pas";