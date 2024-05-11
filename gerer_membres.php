<?php
/*
    URL controleur : si utilisateur connecté gestionnaire, afficher formulaire de creation + listes membres pour modification ou desactivation
    
    Paramètres : aucun
*/

/********************/
/*  INITIALISATIONS */
/********************/
include "library/init.php";

if (session::connexion() and (session::get("role") == "gestionnaire")) {
    
/**********************************************/
/* VERIFICATION / RECUPERATION DES PARAMETRES */
/**********************************************/

/*************************************/
/* RECUPERATION DES INFOS A AFFICHER */
/*      TRAITEMENTS SUR LA BD        */
/*************************************/

    // récupérer la liste des membres
    $membre = new membre();
    $liste = $membre->listeDeroulante();

/*************/
/* AFFICHAGE */
/*************/
    // template de page : "gestion.php"
    // paramètres à passer : $liste, une liste de membres (tableau associatif)
    include "templates/pages/gestion.php";
} else
    header("Location: index.php");

