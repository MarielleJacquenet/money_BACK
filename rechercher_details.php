<?php
/*
    URL controleur : tester si l’utilisateur est connecté, si oui rechercher le projet dont l'id est donné et l'afficher selon l'action donnée
    
    Paramètres : GET id, l'id du projet dont on veut les détails
                     action, indique le type de détails à afficher
                        1 => Gestionnaire - Projets en attente de validation
                        3 => Membre - Mes financements
                        4 => Membre - Projets en cours
                     reste (optionnel si action = 4), le reste à mettre comme borne de saisie pour la participation   
*/

/********************/
/*  INITIALISATIONS */
/********************/
include "library/init.php";

if (session::connexion()) {

/**********************************************/
/* VERIFICATION / RECUPERATION DES PARAMETRES */
/**********************************************/

    if (isset($_GET['id']) and !empty($_GET['id'])) {
        $id_projet= $_GET['id']; 
    } else 
        $id_projet = 0;

    if (isset($_GET['action']) and !empty($_GET['action'])) {
        $action = $_GET['action'];   
    } else
        $action = 0; 

    if (isset($_GET['reste']) and !empty($_GET['reste']))     
        $reste = $_GET['reste'];   

/*************************************/
/* RECUPERATION DES INFOS A AFFICHER */
/*      TRAITEMENTS SUR LA BD        */
/*************************************/

    if (($id_projet !=0) and ($action != 0)) {

        // créer une instance de projet chargée pour l'id donné
        $projet = new projet($id_projet);  

/*************/
/* AFFICHAGE */
/*************/

        if ((session::get("role") == "gestionnaire") and (session::get("role_courant") == "gestionnaire") 
                and ($action == 1)) {         
            // template de page : "details_gestionnaire.php"
            // paramètres à passer : $projet, le projet dont on veut afficher les détails
            include "templates/pages/details_gestionnaire.php";
            exit;
        }

        if (((session::get("role") == "membre") or (session::get("role_courant") == "membre"))
              and (($action == 3) or ($action == 4))) {    
            // template de page : "details_membre.php"
            // paramètres à passer : $projet, le projet dont on veut afficher les détails
            //                       $action, entier qui indique quels détails on veut afficher
            //                       $reste, optionnel, attendu pour $action = 4, le montant restant à financer sur le projet     
            include "templates/pages/details_membre.php";
            exit;
        }
    }
}
// si pas connecté ou problème paramètre, rediriger sur index.php
header("Location: index.php");