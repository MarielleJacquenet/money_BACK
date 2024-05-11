<?php
/*
    URL controleur : modifier le membre dans la BD si possible, et afficher le template de confirmation
    
    Paramètres : GET id, l'id du membre à modifier 
                 POST pseudo, email, mp, nom, prenom, cp, role les données pour modifier le membre dans la BD
                    mp2 la chaine pour confirmer le mot de passe
*/

/********************/
/*  INITIALISATIONS */
/********************/
include "library/init.php";

if (session::connexion() and (session::get("role") == "gestionnaire")) {
    $modifOK = true;
    $message = "";

/**********************************************/
/* VERIFICATION / RECUPERATION DES PARAMETRES */
/**********************************************/
    // si on a un id
    if (isset($_GET['id'])) {
        $membre = new membre($_GET['id']);

        // tester si le pseudo donné en paramètre est différent du pseudo du membre
        if ((!empty($_POST["pseudo"])) and ($_POST["pseudo"] != $membre->get("pseudo"))) {
            // si c'est le cas chercher si le pseudo existe déjà dans la BD 
            $res = $membre2->objetCriteres(["pseudo"=>$_POST["pseudo"]]);
            if ($res) {
                $message .= "Ce pseudo est déjà utilisé<br>"; 
                $modifOK=false;
            } else {
                $membre->set("pseudo",$_POST["pseudo"]);
            }
        }

        // tester si l'email donné en paramètre est différent de l'email du membre
        if ((!empty($_POST["email"])) and ($_POST["email"] != $membre->get("email"))) {
            // si c'est le cas chercher si l'email existe déjà dans la BD 
            $res = $membre2->objetCriteres(["email"=>$_POST["email"]]);
            if ($res) {
                $message .= "Cet email est déjà utilisé<br>"; 
                $modifOK=false;
            } else {
                $membre->set("email",$_POST["email"]);
            }
        }

        // tester si les 2 valeurs du mot de passe sont identiques,
        if (!empty($_POST["mp"]) and (!empty($_POST["mp2"])) and ($_POST["mp"] == $_POST["mp2"])) {
            //  si c'est le cas, modifier l'objet membre
            $membre->set("mp", password_hash($_POST["mp"], PASSWORD_DEFAULT)); 
        } else {
            if ($_POST["mp"] != $_POST["mp2"]) {
                $message .= "Les mots de passe saisis ne correspondent pas<br>";
            $modifOK=false;
            }
        }

        if (!empty($_POST['nom']))
            $membre->set("nom", $_POST['nom']);

        if (!empty($_POST['prenom']))
            $membre->set("prenom", $_POST['prenom']);

        if (!empty($_POST['cp']))   
            $membre->set("cp", $_POST['cp']);

        if (!empty($_POST['role']))
            $membre->set("role", $_POST['role']);

/*************************************/
/* RECUPERATION DES INFOS A AFFICHER */
/*      TRAITEMENTS SUR LA BD        */
/*************************************/

        // modifier la ligne dans la table avec les nouvelles données (si les données sont identiques, la ligne conservera les mêmes données)
        if ($modifOK) {
                $res = $membre->modifieBD();     

                if ($res) 
                    $message .= "Le profil a bien été modifié<br>";
                else
                    $modifOK = false;    
        }
    } else
        $modifOK = false;

    if ($modifOK == false)
        $message .= "Erreur lors de la modification du profil<br>";
        
/*************/
/* AFFICHAGE */
/*************/
    // template de page : "confirm_modif_membre.php"
    // paramètres à passer : $message, le message à afficher
    include "templates/pages/confirm_modif_membre.php";

} else
    // si pas connecte, rediriger sur index.php
    header("Location: index.php");