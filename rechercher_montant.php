<?php
/*
    URL controleur : rechercher le montant restant à financer pour le projet donné et l'afficher (fonction liée à un appel ajax)
    
    Paramètres : POST id, l'id du projet
*/

/********************/
/*  INITIALISATIONS */
/********************/
include "library/init.php";

/**********************************************/
/* VERIFICATION / RECUPERATION DES PARAMETRES */
/**********************************************/

if (isset($_REQUEST['id']) and !empty($_REQUEST['id'])) {

/*************************************/
/* RECUPERATION DES INFOS A AFFICHER */
/*      TRAITEMENTS SUR LA BD        */
/*************************************/
    $projet = new projet($_REQUEST['id']);
    $montant = $projet->montantFinance();

/*************/
/* AFFICHAGE */
/*************/
    // afficher les données 
    echo $montant;
}