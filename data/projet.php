<?php

/********************************/
/*         Classe : projet        */
/********************************/

/*******************************************************************
    Méthodes disponibles : 

    * Toutes les méthodes héritées de la classe library/baseObjet
   +
    * listeValideResteAFinancer() : cherche la une liste des projets validés en recherche de financement
    * listeFinancements() : renvoie la liste de tous les financements promis pour le projet courant
    * listeProjetsAcceptes() : renvoie la liste de tous les projets acceptés, en cours ou financés
    * montantPromis($id_membre) : renvoie la somme des montants promis pour le projet en cours par le membre d'id donné
    * montantRestantAFinancer() : renvoie le montant restant à financer pour le projet en cours
    * montantFinance() : renvoie le montant déjà financé pour le projet en cours

    * mailAcceptation() : gère l'envoi d'un mail d'acceptation au porteur du projet
    * mailRefus($motif) : gère l'envoi d'un mail de refus au porteur du projet
    * mailFinancementOKPorteur() : gère l'envoi d'un mail au porteur du projet pour le prévenir que le projet est totalement financé
    * mailFinancementOKInvestisseur($id_membre) : gère l'envoi d'un mail à un investisseur du projet pour le prévenir que le projet est totalement financé

********************************************************************/

class projet extends baseObjet {

    ////////////////
    // PROPRIETES //
    ////////////////

    protected $champs = ["titre","description","montant","porteur","statut","date","code"]; // liste des champs hors id
    protected $table = "projet";  // nom de la table dans la BDD
    protected $liens = ["porteur"=>"porteur"];
    protected $types = ["titre"=>"texte","description"=>"texte","montant"=>"nombre","porteur"=>"lien","statut"=>"texte","date"=>"date","code"=>"texte"]; // types : "lien","texte","nombre","date"

    /////////////////////////////////////
    // METHODES EXCLUSIVES A LA CLASSE //
    /////////////////////////////////////

    function projetsFinancesMembre($id_membre) {
        // Rôle : cherche la liste des projets totalement financés auquels le membre d'id donné a participé
        // Retour : la liste trouvée (tableau associatif)
        // Paramètres : $id_membre, l'id du membre

        // création de la requête
        $sql = "SELECT `projet`.`id`, .`projet`.`titre`, `projet`.`description`, `projet`.`montant`, 
        SUM(`financement`.`montant`) AS 'total'
        FROM `projet` LEFT JOIN `financement`
        ON `financement`.`projet` = `projet`.`id`
        WHERE `statut`='finance' AND `financement`.`membre`=:id_membre 
        GROUP BY `projet`.`id`";

        // traitement et récupération d'un tableau indexé sur l'id
        return $this->traiteReqListeTabAssoc($sql,[":id_membre"=>$id_membre]);        
    }

    function listeValideResteAFinancer() {
        // Rôle : cherche la liste des projets en recherche de financement avec le reste à financer
        // Retour : la liste trouvée (tableau associatif)
        // Paramètres : aucun

        // création de la requête
        $sql = "SELECT `projet`.`id`, .`projet`.`titre`, `projet`.`description`, `projet`.`montant`, 
        `projet`.`montant` - SUM(`financement`.`montant`) AS 'reste'
        FROM `projet` LEFT JOIN `financement`
        ON `financement`.`projet` = `projet`.`id`
        WHERE `statut`='valide'
        GROUP BY `projet`.`id`";

        // traitement et récupération d'un tableau indexé sur l'id
        return $this->traiteReqListeTabAssoc($sql);
    }

    function listeFinancements() {
        // Rôle : cherche la liste de tous les financements promis pour le projet courant
        // Retour : la liste d'objets financement trouvée
        // Paramètre : aucun

        $financement = new financement();
        return $financement->listeCriteres(["projet"=>$this->getId()]);
    }

    function listeProjetsAcceptes() {
        // Rôle : cherche la liste de tous les projets acceptés, en cours ou financés
        // Retour : la liste d'objets projets trouvée
        // Paramètre : aucun

        // requête qui ne peut pas être faite avec listeCriteresOU car 2 conditions sur le même champ
        $sql = "SELECT `id`,`titre`,`description`,`montant`,`porteur`,`statut`,`date`,`code` 
                FROM `projet` WHERE `statut` = 'valide' OR `statut` = 'finance' 
                ORDER BY date DESC";

        // traitement et récupération d'une liste d'objets projet
        return $this->traiteReqListeObjets($sql);
    }
      
    function montantPromis($id_membre) {
        // Rôle : cherche la somme des montants promis pour le projet en cours par le membre d'id donné
        // Retour : le montant (entier)
        // Paramètres : $id_membre, l'id du membre dont on cherche le montant promis

        // preparer la requete
        $sql = "SELECT SUM(`montant`) as 'montant' FROM `financement` 
                WHERE `projet`=:id_projet AND `membre`= :id_membre";
        $param = [":id_projet" =>$this->getId(), ":id_membre" =>$id_membre];

        // preparer et exécuter la requête
        $requete = $this->prepareExecuteRequete($sql, $param);

        $tab = $requete->fetch(PDO::FETCH_ASSOC);

        if (is_null($tab["montant"]))
            return 0;
        else    
            return $tab["montant"];
    }

    function montantRestantAFinancer() {
        // Rôle : cherche le montant restant à financer pour le projet en cours
        // Retour : le montant (entier)
        // Paramètres : aucun  

        // preparer la requete pour trouver le montant total financé
        $sql = "SELECT SUM(`montant`) AS 'total' FROM `financement` 
        WHERE `projet` = :id_projet";

        // preparer et exécuter la requête
        $requete = $this->prepareExecuteRequete($sql, [":id_projet" => $this->getId()]);

        $tab = $requete->fetch(PDO::FETCH_ASSOC);

        // montant restant à financer = montant du projet - total financé
        if (is_null( $tab["total"]))
            return $this->get("montant");
        else    
            return $this->get("montant") - $tab["total"];
    }

    function montantFinance() {
        // Rôle : cherche le montant déjà financé pour le projet en cours
        // Retour : le montant (entier)
        // Paramètres : aucun  

        // preparer la requete pour trouver le montant total financé
        $sql = "SELECT SUM(`montant`) AS 'total' FROM `financement` 
        WHERE `projet` = :id_projet";

        // preparer et exécuter la requête
        $requete = $this->prepareExecuteRequete($sql, [":id_projet" => $this->getId()]);

        $tab = $requete->fetch(PDO::FETCH_ASSOC);

        // montant restant à financer = montant du projet - total financé
        if (is_null( $tab["total"]))
            return 0;
        else    
            return $tab["total"];
    }


    function mailAcceptation() {
        // Role : gère l'envoi d'un mail d'acceptation au porteur du projet
        // Retour : aucun
        // Paramètres : aucun
    
        include "templates/fragments/destinatairePorteur.php";

        // sujet
        $sujet = "Projet accepté sur MONEY";
        
        // message à envoyer 
        // ouvrir le buffer
        ob_start();
        // mettre le contenu du template dans le buffer  
        include "templates/mails/mail_accepte_projet.php";
        // récupérer le contenu du buffer dans une chaine et vider le buffer
        $message = ob_get_clean();

        // envoi du mail
        include "templates/fragments/envoi_mail.php";
    }

    function mailRefus($motif) {
        // Role : gère l'envoi d'un mail de refus au porteur du projet
        // Retour : aucun
        // Paramètres : $motif, le motif du refus
    
        include "templates/fragments/destinatairePorteur.php";

        // sujet
        $sujet = "MONEY - Réponse à votre soumission de projet";
        
        // message à envoyer 
        // ouvrir le buffer
        ob_start();
        // mettre le contenu du template dans le buffer  
        include "templates/mails/mail_refus_projet.php";
        // récupérer le contenu du buffer dans une chaine et vider le buffer
        $message = ob_get_clean();

        // envoi du mail
        include "templates/fragments/envoi_mail.php";
    }

    function mailFinancementOKPorteur() {
        // Role : gère l'envoi d'un mail au porteur du projet pour le prévenir que le projet est totalement financé
        // Retour : aucun
        // Paramètres : aucun
    
        include "templates/fragments/destinatairePorteur.php";

        // sujet
        $sujet = "MONEY - Un projet auquel vous participez est totalement financé";
        
        // message à envoyer 
        // ouvrir le buffer
        ob_start();
        // mettre le contenu du template dans le buffer  
        include "templates/mails/mail_projet_finance_porteur.php";
        // récupérer le contenu du buffer dans une chaine et vider le buffer
        $message = ob_get_clean();

        // envoi du mail
        include "templates/fragments/envoi_mail.php";
    }

    function mailFinancementOKInvestisseur($id_membre) {
        // Role : gère l'envoi d'un mail à un investisseur du projet donné pour le prévenir que le projet est totalement financé
        // Retour : aucun
        // Paramètres : $id_membre, l'id du membre à qui le mail doit être envoyé
    
        // récupérer le pseudo et l'email du destinataire
        $membre = new membre($id_membre);
        $nomDestinataire = $membre->getLibelle();
        $emailDestinataire = "mjacquenet@mywebecom.ovh"; //$membre->get("email") si vraie boite mail;

        // destinataire
        $destinataire = '"'.$nomDestinataire.'"'."<$emailDestinataire>";

        // sujet
        $sujet = "Financement de votre projet MONEY";
        
        // message à envoyer 
        // ouvrir le buffer
        ob_start();
        // mettre le contenu du template dans le buffer  
        include "templates/mails/mail_projet_finance_investisseur.php";
        // récupérer le contenu du buffer dans une chaine et vider le buffer
        $message = ob_get_clean();

        // envoi du mail
        include "templates/fragments/envoi_mail.php";
    }

}