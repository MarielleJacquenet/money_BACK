<?php 
/*
    Template de fragment : traitement final pour l'envoi de mail par un gestionnaire 

    Paramètres : aucun 
*/


        // entête 
        $entete = ["From"=> '"Contact" <---@--->',        // adresse serveur
        "Reply-To"=> '"Moi" <---@--->',
        "MIME-version" => "1.0",
        "Content-Type" => "text/html; charset=utf8"];

        // envoi du mail
        mail($destinataire, $sujet, $message, $entete);