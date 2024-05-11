<?php
/*
    URL controleur : rechercher la liste selon l'action donnée et l'afficher
    
    Paramètres : GET action, entier, le type de liste à chercher
                        1 => Gestionnaire - Projets en attente de validation
                        2 => Gestionnaire - Liste des projets acceptés  
                        3 => Membre - Mes financements promis
                        4 => Membre - Projets en cours avec montant restant
                        5 => Membre - Projets terminés (tous)
                        6 => Membre - Mes projets terminés
*/

/********************/
/*  INITIALISATIONS */
/********************/
include "library/init.php";

if (session::connexion()) {
    
/**********************************************/
/* VERIFICATION / RECUPERATION DES PARAMETRES */
/**********************************************/

    if (isset($_REQUEST['action']) and !empty($_REQUEST['action'])) {
        $action = $_REQUEST['action']; // sera passé en paramètre au templates

/*************************************/
/* RECUPERATION DES INFOS A AFFICHER */
/*      TRAITEMENTS SUR LA BD        */
/*************************************/
/*************/
/* AFFICHAGE */
/*************/
        // nouveau projet pour la recherche de liste de projets
        $projet = new projet();

        if ((session::get("role") == "gestionnaire") and (session::get("role_courant") == "gestionnaire")) {
            if ($action == 1) {
                // on cherche la liste des projets en attente de validation (idem accueil_gestionnaire)           
                $liste = $projet->listeCriteres(["statut" => "attente"],["date" => "DESC"]);
            } else {
                $liste = $projet->listeProjetsAcceptes();
            }
            // template de page : "accueil_gestionnaire.php"
            // paramètres à passer : $liste
            //                       $action
            include "templates/pages/accueil_gestionnaire.php";
            exit;
        }
        
        if ((session::get("role") == "membre") or (session::get("role_courant") == "membre")) {
            switch ($action) {
            case 3 : $financement = new financement();
                     $liste = $financement->promessesFinancement(session::get("id"));
                     break;
            case 4 : $liste = $projet->listeValideResteAFinancer();
                     break;
            case 5 : $liste = $projet->listeCriteres(["statut" => "finance"],["date" => "DESC"]); 
                     break;
            case 6 : $liste = $projet->projetsFinancesMembre(session::get("id"));        
            }
            // template de page : "accueil_membre.php"
            // paramètres à passer : $liste
            //                       $action
            include "templates/pages/accueil_membre.php";
            exit;
        }
    }
}
// si pas connecté ou pas d'action demandée, rediriger sur index.php
header("Location: index.php");