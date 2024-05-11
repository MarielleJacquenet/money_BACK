<?php
/*
    URL controleur : enregistrer le projet dans la BD et afficher la page de confirmation
    
    Paramètres : POST titre, description, montant, nom, prenom, email, adresse, telephone les données de base pour créer une nouvelle ligne dans les tables projet et porteur
                 POST affich_suite, indique si le porteur a demandé à réutiliser des données déjà enregistrées   
    */

/********************/
/*  INITIALISATIONS */
/********************/
include "library/init.php";

// créer les objets porteur et projet
$porteur = new porteur();
$projet = new projet();

// initialiser la variable $res à true (variable qui indique la réussite ou l'échec des différents tests successifs)
$res = 1;

afRes($_POST);

/**********************************************/
/* VERIFICATION / RECUPERATION DES PARAMETRES */
/**********************************************/

// tester si tous les paramètres attendus existent
if (isset($_POST['titre']) and isset($_POST['description']) and isset($_POST['montant']) and isset($_POST['nom']) and isset($_POST['prenom']) and isset($_POST['email']) and isset($_POST['adresse']) and isset($_POST['telephone']))
        $res = 1;
    else 
        $res= 0;

/*************************************/
/* RECUPERATION DES INFOS A AFFICHER */
/*      TRAITEMENTS SUR LA BD        */
/*************************************/

// si ils existent on peut continuer la création d'un nouveau projet 
if ($res){
    // si $_POST affich_suite = "oui", le porteur du projet a demandé à réutiliser les données enregistrées 
    // pour un autre projet => chercher les données correspondant au mail donné par le porteur
    if ($_POST["affich_suite"] == "oui")  {
        $res = $porteur->objetCriteres(["email"=> $_POST["email"]]);

        // si on a trouvé le porteur, pas besoin de le recréer, on récupère son id 
        if ($res) 
            $id_porteur = $porteur->getId();  
        else
            $id_porteur = 0;
    }       
    else {
        // sinon il faut remplir l'objet porteur avec les données de $_POST, qui doivent exister
        if (($_POST['nom'] != "") and ($_POST['prenom'] != "") and ($_POST['email'] != "") and ($_POST['adresse'] != "") and ($_POST['telephone'] != "")) {
            $porteur->set("nom",$_POST["nom"]);
            $porteur->set("prenom",$_POST["prenom"]);
            $porteur->set("email",$_POST["email"]);
            $porteur->set("adresse",$_POST["adresse"]);
            $porteur->set("telephone",$_POST["telephone"]);

            // puis creer la ligne dans la table porteur et récupérer son id
            $id_porteur = $porteur->creeDansBD();
        } else {
            $res=0;
            $id_porteur = 0;
        }
    }    

    // si on a un id != 0, et $res = 1, on peut continuer en créant le projet
    if (($id_porteur != 0) and ($res == 1)) {
        // récupérer les données enregistrées dans $_POST
        $projet->set("titre", $_POST['titre']);
        $projet->set("description", $_POST['description']);
        $projet->set("montant", $_POST['montant']);
        // ajouter l'id, le statut, la date, un code unique dans l'objet projet
        $projet->set("porteur", $id_porteur);
        $projet->set("statut","attente");
        $projet->set("date", date('Y-m-d'));
        $projet->set("code", uniqid());

        // puis creer la nouvelle ligne dans la table projet 
        $res = $projet->creeDansBD();
    } else {
        // sinon il y a eu un échec dans les étapes précédentes
        $res = 0;
    }    
} else
    // sinon indiquer l'échec de la création
    $res=0;

/*************/
/* AFFICHAGE */
/*************/
// template de page : "confirm_projet.php"
// paramètres à passer : $res, l'id du projet créé ou 0 si pb lors de la création
include "templates/pages/confirm_projet.php";

