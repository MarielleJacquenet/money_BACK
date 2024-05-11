<?php
/*
    URL controleur : affiche une page dépendant de la connection ou non de l'utilisateur et si oui, de son rôle
    
    Paramètres : optionnel GET role indique qu'un membre gestionnaire veut changer de role (role = "gestionnaire" ou "membre")
*/

/********************/
/*  INITIALISATIONS */
/********************/
include "library/init.php";

if (session::connexion()) {
    // charger l'objet utilisateur connecté dans la propriété de la session
    session::chargeMembreConnecte();
    
/**********************************************/
/* VERIFICATION / RECUPERATION DES PARAMETRES */
/**********************************************/

    if (session::getMembreConnecte()->get('role') == 'gestionnaire') {

        // tester existence role, et changer si un role est donné 
        if (isset($_GET['role']) and !empty($_GET['role'])) {
            session::modifRoleConnecte($_GET['role']);
        }
    }    
/*************************************/
/* RECUPERATION DES INFOS A AFFICHER */
/*      TRAITEMENTS SUR LA BD        */
/*************************************/
/*************/
/* AFFICHAGE */
/*************/
    if (session::get('role_courant') == 'gestionnaire') {
        // on cherche la liste des projets en attente de validation            
        $projet = new projet();
        $liste = $projet->listeCriteres(["statut" => "attente"],["date" => "DESC"]);

        // indiquer le type de liste à traiter
        $action = 1;
        // template de page : "accueil_gestionnaire.php"
        // paramètres à passer : $liste, la liste des projets à afficher
        //                       $action, indique le type de liste
        include "templates/pages/accueil_gestionnaire.php";
    }   
    else {
        // on cherche la liste des financements promis par le membre connecté
        $financement = new financement();
        $liste = $financement->promessesFinancement(session::get("id"));

        // indiquer le type de liste à traiter
        $action = 3;
        // template de page : "accueil_membre.php"
        // paramètres à passer : $liste, la liste des projets à afficher
        //                       $action, indique le type de liste
        include "templates/pages/accueil_membre.php";
    }
} else {
    // on cherche la liste des 5 projets en cours les plus récents
    $projet = new projet();
    $liste = $projet->listeCriteres(["statut" => "valide"],["date" => "DESC"],5);

    // template de page : "accueil.php"
    // paramètres à passer : $liste, la liste des projets à afficher
    include "templates/pages/accueil.php";
}