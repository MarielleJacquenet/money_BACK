<?php
/*
    URL controleur : connecter et rediriger sur index.php
    
    Paramètres : POST login, mp, les infos pour la connexion
*/

/********************/
/*  INITIALISATIONS */
/********************/
include "library/init.php";

/**********************************************/
/* VERIFICATION / RECUPERATION DES PARAMETRES */
/**********************************************/

if (isset($_POST['login']) and isset($_POST['mp'])) {

/*************************************/
/* RECUPERATION DES INFOS A AFFICHER */
/*      TRAITEMENTS SUR LA BD        */
/*************************************/

    // essayer de connecter le membre dont on a les données
    session::connecter($_POST['login'], $_POST['mp']);
}

/*************/
/* AFFICHAGE */
/*************/
// redirection sur la page "index.php"
// paramètres à passer : aucun
header("Location: index.php");