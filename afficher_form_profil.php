<?php
/*
    URL controleur : afficher le formulaire de modification d'un membre
    
    Paramètres : POST id, l'id du membre à modifier
*/

/********************/
/*  INITIALISATIONS */
/********************/
include "library/init.php";

if (session::connexion() and (session::get("role") == "gestionnaire")) {    // mettre l'objet utilisateur connecté "en cache" (on le charge dans la propriété de la session)
    
/**********************************************/
/* VERIFICATION / RECUPERATION DES PARAMETRES */
/**********************************************/

    if (isset($_POST['id']) and !empty($_POST['id'])) {

/*************************************/
/* RECUPERATION DES INFOS A AFFICHER */
/*      TRAITEMENTS SUR LA BD        */
/*************************************/
        $membre = new membre($_POST['id']);

/*************/
/* AFFICHAGE */
/*************/
        // template de page : "form_modif_profil.php"
        // paramètres à passer : $membre, l'objet contenant les infos de profil à modifier
        include "templates/pages/form_modif_profil.php";
        exit;
    }
} 
// si pas connecte, rediriger sur index.php
header("Location: index.php");