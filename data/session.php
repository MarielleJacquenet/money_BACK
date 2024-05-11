<?php

/********************************/
/*         Classe : session        */
/********************************/

/*******************************************************************
    Méthodes disponibles : 

    * get($cle) : renvoie la valeur enregistrée dans $_SESSION pour la clé donnée en paramètre
    * set($cle, $valeur) : affecte la valeur donnée en paramètre à $_SESSION pour la clé donnée 
    * start() : démarre la session 
    * connexion() : teste si un utilisateur est connecté (renvoie true ou false)
    * membreConnecte() : renvoie l'objet membre enregistré dans la propriété $membreConnecte
    * chargeMembreConnecte() : recupère l'objet membre correspondant à l'utilisateur connecté dans la BD  et le charge dans $membreConnecte
    * connecte($login, $mp) : connecte le membre dont le login et le mot de passe sont donnés si il existe dans la table "membre" 
    * modifRoleConnecte($role) : change le role courant du membre connecte si le membre connecté est gestionnaire
    * deconnecter() : déconnecte le membre connecte = reinitialise les données enregistrées dans $_SESSION

********************************************************************/

class session {

    protected static $membreConnecte; // permet d'enregistrer l'objet correpondant au membre connecté

    static function get($cle) {
        // Rôle : renvoie la valeur enregistrée dans $_SESSION pour la clé donnée en paramètre
        // Retour : la valeur trouvée
        // Paramètres : $cle, la clé pour laquelle on veut récupérer la valeur enregistrée dans $_SESSION

        return $_SESSION[$cle];
    }

    static function set($cle, $valeur) {
        // Rôle : affecte la valeur donnée en paramètre à $_SESSION pour la clé donnée 
        // Retour : aucun
        // Paramètres : $cle, la clé pour laquelle on veut enregistrer une valeur dans $_SESSION
        //              $valeur, la valeur à assigner 

        $_SESSION[$cle] = $valeur;        
    }    

    static function start() {
        // Rôle : démarre la session 
        // Retour : aucun
        // Paramètres : aucun

        // démarrer la session
        session_start();
    }

    static function connexion() {
        // Rôle : teste si un utilisateur est connecté
        // Retour : true si un utilisateur est connecté, false sinon
        // Paramètres : aucun

        if (isset($_SESSION["id"]) and (self::get("id") != 0)) 
            return true ;
        else    
            return false ;
    }

    static function getMembreConnecte() {
        // Rôle : renvoie l'objet membre enregistré dans la propriete $membreConnecte 
        // Retour : l'objet membre 
        // Paramètres : aucun

        return self::$membreConnecte;
    }

    static function chargeMembreConnecte() {
        // Rôle : récupère l'objet membre correspondant à l'utilisateur connecté dans la BD et le charge dans $membreConnecte
        // Retour : aucun
        // Paramètres : aucun

        $membre = new membre();
        $membre->objetCriteres(self::get("id"));
        self::$membreConnecte = $membre;
    }

    static function connecter($login, $mp) {
        // Rôle : connecte le membre dont le login et le mot de passe sont donnés si il existe dans la table "membre" 
        // Retour : true si connexion réussie, false sinon
        // Paramètres : $login, le login à tester (pseudo ou email)
        //              $mp, le mot de passe à tester    

        //créer un objet membre
        $membre = new membre();

        // si le login existe dans les pseudos et email
        $res = $membre->objetCriteresOU(["email"=>$login, "pseudo"=>$login]);

        if ($res) {
            //si le mot de passe correspondant est celui donné en paramètres et que le membre a un statut actif
            if (password_verify($mp, $membre->get("mp")) and ($membre->get("statut") == "actif")) {
                // connecter le membre :           
                // enregistrer son id dans $_session
                self::set("id",$membre->getId());

                // enregistrer son pseudo dans $_session
                self::set("pseudo",$membre->get("pseudo"));

                // enregistrer son role dans $_session
                self::set("role",$membre->get("role"));

                // enregistrer le role courant dans $_session
                self::set("role_courant",$membre->get("role"));

                // renvoyer true
                return true ;
            } 
        } 

        // dans tous les autres cas, renvoyer false
        return false;
    }

    static function modifRoleConnecte($role) {
        // Rôle : change le role courant du membre connecte si le membre connecté est gestionnaire
        // Retour : aucun
        // Paramètres : $role le nouveau role à attribuer ("membre" ou "gestionnaire")   

        if (self::get("role") == "gestionnaire"){
            self::set("role_courant",$role);
        }
    }

    static function deconnecter() {
        // Rôle : déconnecte le membre connecte = reinitialise les données enregistrées dans $_SESSION
        // Retour : aucun
        // Paramètres : aucun

        // réinitialiser l'id à 0 dans $_session
        self::set("id", 0);

        // réinitialiser le pseudo à "" dans $_session
        self::set("pseudo","");

        // réinitialiser le role à "" dans $_session
        self::set("role","");

        // réinitialiser le role courant à "" dans $_session
        self::set("role_courant","");
    }


}