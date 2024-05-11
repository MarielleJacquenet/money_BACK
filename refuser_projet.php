<?php
/*
    URL controleur : mettre le statut du projet à refuse dans la BD et envoyer un mail de refus
    
    Paramètres : GET id, l'id du projet 
                 POST $motif, chaine contenant le motif du refus
*/

/********************/
/*  INITIALISATIONS */
/********************/
include "library/init.php";

if (session::connexion() and (session::get("role") == "gestionnaire")) {
    
/**********************************************/
/* VERIFICATION / RECUPERATION DES PARAMETRES */
/**********************************************/

if (isset($_GET["id"]) and !empty($_GET["id"])) {
    $projet = new projet ($_GET["id"]);
    
    if (isset($_POST["motif"]) and !empty($_POST["motif"])) 
        $motif = $_POST["motif"];
    else
        $motif = "Aucun motif enregistré";    

/*************************************/
/* RECUPERATION DES INFOS A AFFICHER */
/*      TRAITEMENTS SUR LA BD        */
/*************************************/

        // modifier date pour mettre date refus
        $projet->set("date",date("Y-m-d"));

        // modifier le statut du projet
        $projet->set("statut","refuse");

        // faire la modification dans la BD
        $res = $projet->modifieBD();

        // envoyer un mail avec id projet et code enregistré dans BD pour afficher le suivi du projet
        if ($res)
            $projet->mailRefus($motif);

/*************/
/* AFFICHAGE */
/*************/
        else
            echo "Erreur lors du traitement de la demande";
    }
}
// redirection sur l'index qui affichera la liste mise à jour des projets en attente de validation
header("Location: index.php");