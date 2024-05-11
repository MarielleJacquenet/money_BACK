<?php 
/*
    Template de fragment : gestion du destinataire pour l'envoi de mail à un porteur de projet

    Paramètres : $this, le projet
*/

        // récupérer le pseudo et l'email du destinataire
        $nomDestinataire = $this->get("porteur")->getLibelle();
        $emailDestinataire = "---@---"; //$this->get("porteur")->get("email") si vraie boite mail;

        // destinataire
        $destinataire = '"'.$nomDestinataire.'"'."<$emailDestinataire>";