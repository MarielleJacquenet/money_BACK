<?php
/*
    URL controleur : enregistrer le montant de la participation du membre connecté pour le projet d'id donné dans la BD, et recalculer la somme restante. 
                Si somme restante = 0, mettre le statut du projet à finance + envoyer mails porteur et participants
    
    Paramètres : GET id, l'id du projet
                 POST montant, le montant à enregistrer pour la participation de l'utilisateur connecté
*/

/********************/
/*  INITIALISATIONS */
/********************/
include "library/init.php";

if (session::connexion()) {  
    $reussite = true;
    
/**********************************************/
/* VERIFICATION / RECUPERATION DES PARAMETRES */
/**********************************************/

    // si on a les paramètres, on peut gérer la participation
    if (isset($_GET['id']) and isset($_POST['montant']) and !empty($_GET['id']) and !empty($_POST['montant'])) {
        $id = $_GET['id'];
        $montant = $_POST['montant'];

/*************************************/
/* RECUPERATION DES INFOS A AFFICHER */
/*      TRAITEMENTS SUR LA BD        */
/*************************************/
        // récupérer l'objet projet d'id donné
        $projet = new projet ($id);

        // vérifier que le montant ne dépasse pas le reste à payer
        if ($montant <= $projet->montantRestantAFinancer()) {
            // on créer un nouveau financement avec les infos transmises
            $financement = new financement();
            $financement->set("montant", $montant);
            $financement->set("projet", $id);
            $financement->set("membre", session::get("id"));

            $id_financ = $financement->creeDansBD();

            // si la création a bien eu lieu (id!=0)
            if ($id_financ != 0) {
                // si le projet est totalement financé,
                if ($projet->montantRestantAFinancer() == 0) { 
                    // mettre le statut à "finance" dans le projet
                    $projet->set("statut","finance");
                    $projet->modifieBD();

                    // envoyer des mails au porteur et aux investisseurs pour les prévenir
                    $projet->mailFinancementOKPorteur();
                    $liste = $financement->listeCriteres(["projet"=> $id]);
                    foreach ($liste as $financement) {
                        $projet->mailFinancementOKInvestisseur($financement->getValeur("membre"));
                    }
                }
            
/*************/
/* AFFICHAGE */
/*************/
                // rediriger sur index
                // paramètres à passer : 
                include "";
            } else 
                $reussite = false;    
        } else 
            $reussite = false;
    } else 
        $reussite = false;
} else
    $reussite = false;

if ($reussite)
    header ("Location: index.php");
else
    echo "Erreur lors de l'enregistrement de la participation";

