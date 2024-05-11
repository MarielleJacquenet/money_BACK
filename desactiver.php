<?php
/*
    URL controleur : mettre le statut à desactive dans la BD, et retourner sur la page gestion
    
    Paramètres : POST id, l'id du membre à modifier
*/

/********************/
/*  INITIALISATIONS */
/********************/
include "library/init.php";

if (session::connexion() and (session::get("role") == "gestionnaire")) {
    
    $modifOK = true;

/**********************************************/
/* VERIFICATION / RECUPERATION DES PARAMETRES */
/**********************************************/

    if (isset($_POST['id']) and !empty($_POST['id'])) {
        $id = $_POST['id'];

/*************************************/
/* RECUPERATION DES INFOS A AFFICHER */
/*      TRAITEMENTS SUR LA BD        */
/*************************************/
        // charger l'objet correspondant à l'id
        $membre = new membre($id);

        // modifier le staut dans l'objet
        $membre->set("statut","desactive");

        // répercuter la modification dans la BD
        $res = $membre->modifieBD();        

        if (!$res)
           $modifOK = false;

/*************/
/* AFFICHAGE */
/*************/
    } else
        $modifOK = false;

    if ($modifOK) 
        echo "Le profil a bien été modifié<br>";
    else
        echo "Echec de la modification<br>"; 
    echo "<a href='gerer_membres.php'><button>Retourner sur le page de gestion des membres</button></a>";
} else
    // si pas connecte, rediriger sur index.php
    header("Location: index.php");