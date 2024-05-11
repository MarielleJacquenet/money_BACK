<?php
/*
    URL controleur : mettre le statut du projet à valide dans la BD et envoyer un mail avec lien pour suivi
    
    Paramètres : GET id, l'id du projet 
                 POST description, chaine contenant la nouvelle description
*/

/********************/
/*  INITIALISATIONS */
/********************/
include "library/init.php";

if (session::connexion()) {

/**********************************************/
/* VERIFICATION / RECUPERATION DES PARAMETRES */
/**********************************************/
    if ((session::get("role") == "gestionnaire") and (isset($_GET["id"]))) {

        $projet = new projet ($_GET["id"]);
        
        // on enregistre la modification de la description seulement si elle n'est pas vide
        if (isset($_POST["description"]) and (!empty($_POST["description"]))) 
            $projet->set("description", $_POST["description"]);

/*************************************/
/* RECUPERATION DES INFOS A AFFICHER */
/*      TRAITEMENTS SUR LA BD        */
/*************************************/

        // modifier date pour mettre date acceptation
        $projet->set("date",date("Y-m-d"));

        // modifier le statut du projet
        $projet->set("statut","valide");

        // faire la modification dans la BD
        $res = $projet->modifieBD();

        // envoyer un mail avec id projet et code enregistré dans BD pour afficher le suivi du projet
        if ($res)
            $projet->mailAcceptation();

/*************/
/* AFFICHAGE */
/*************/
        else
            echo "Erreur lors du traitement de la demande";
    }
}
// redirection sur l'index qui affichera la liste mise à jour des projets en attente de validation
header("Location: index.php");