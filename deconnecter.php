<?php
/*
    URL controleur : déconnecter l'utilisateur et rediriger sur index.php
    
    Paramètres : aucun
*/

/********************/
/*  INITIALISATIONS */
/********************/
include "library/init.php";

/**********************************************/
/* VERIFICATION / RECUPERATION DES PARAMETRES */
/**********************************************/


/*************************************/
/* RECUPERATION DES INFOS A AFFICHER */
/*      TRAITEMENTS SUR LA BD        */
/*************************************/

// déconnecteur le membre connecté
session::deconnecter();

/*************/
/* AFFICHAGE */
/*************/
// redirection sur la page "index.php"
// paramètres à passer : aucun
header("Location: index.php");