<?php
/*
    URL controleur : enregistrer le nouveau membre dans la BD si c'est possible, et afficher un template de confirmation
    
    Paramètres : POST pseudo, email, mp, nom, prenom, cp, role les données pour créer un nouveau membre dans la BD
                    mp2 la chaine pour confirmer le mot de passe
*/


/********************/
/*  INITIALISATIONS */
/********************/
include "library/init.php";

if (session::connexion() and (session::get("role") == "gestionnaire")) {
    $creationOK = true;
    $message = "";
    
/**********************************************/
/* VERIFICATION / RECUPERATION DES PARAMETRES */
/**********************************************/

    // si tous les paramètres existent et ne sont pas vides
    if (existe_nonvide([],["pseudo","email","mp","mp2","nom","prenom","cp","role"])) {

/*************************************/
/* RECUPERATION DES INFOS A AFFICHER */
/*      TRAITEMENTS SUR LA BD        */
/*************************************/

        // si les 2 mots de passe sont bien identiques
        if ( $_POST['mp'] ==  $_POST['mp2']) {
            // si le pseudo et l'email ne sont pas encore enregistrés dans la BD
            $membre = new membre();
            if ($membre->objetCriteres(["pseudo"=>$_POST['pseudo']]) == true) {
                $message .= "Inscription impossible.<br>Ce pseudo est déjà utilisé<br>";
                $creationOK = false;
            }
            elseif ($membre->objetCriteres(["email"=>$_POST['email']]) == true) {        
                $message .= "Inscription impossible.<br>Cet email est déjà enregistré<br>";
                $creationOK = false;
            }
            else {
                // charger l'objet membre avec les données
                $membre->set("pseudo", $_POST['pseudo']);
                $membre->set("email", $_POST['email']);
                $membre->set("mp", password_hash($_POST['mp'], PASSWORD_DEFAULT)); 
                $membre->set("nom", $_POST['nom']);
                $membre->set("prenom", $_POST['prenom']);
                $membre->set("cp", $_POST['cp']);
                $membre->set("role", $_POST['role']);
                $membre->set("statut", "actif");

                // créer la ligne dans la table
                $id = $membre->creeDansBD();

                if ($id != 0)
                $message .= "Le profil a bien été créé<br>";
                else
                    $creationOK = false;
            }
        } else { 
            $message .= "Les 2 mots de passe ne sont pas identiques<br>";
            $creationOK = false;
        }
    } else {
        $message .= "Erreur de paramètres<br>";
        $creationOK = false;
    }

    if ($creationOK == false)
        $message .= "Erreur lors de la création du profil<br>";

/*************/
/* AFFICHAGE */
/*************/
    // template de page : "confirm_inscription.php"
    // paramètres à passer : $message, le message à afficher
    include "templates/pages/confirm_inscription.php";

} else
// si pas connecte, rediriger sur index.php
header("Location: index.php");