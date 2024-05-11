<?php

/********************************/
/*     Classe : baseObjet       */
/********************************/

/*******************************************************************
    Méthodes disponibles : 

    * __construct ($id = 0) : constructeur : crée une instance de la classe, et la charge si un id est donné
    * getId() : retourne l'id de l'objet courant
    * getValeur($nomChamp) : retourne la valeur "brute" du champ de nom indiqué (valeur enregistrée dans la BD)
    * get($nomChamp) : retourne la valeur du champ dont le nom est passé en paramètre, en fonction de son type
    * getLibelle() : renvoie une chaine contenant les valeurs des champs appartenant au tableau libelle
    * getObjetLien($nomChamp) : retourne l'objet pointé par le champ donné de l'objet courant
    * objetVideLien($nomChamp) : retourne un objet vide défini par l'objet sur lequel pointe le lien enregistré dans le tableau des champs
    * set($nomChamp, $valeur) : donne au champ dont le nom est passé en paramètre la valeur passée en paramètre
 
    * chargeObjetDepuisTableau($tab) : charge l'objet courant avec les éléments du tableau indexé sur les champs passé en paramètre
    
    * prepareExecuteRequete($sql, $param) : prépare et exécute une requête SQL dans la base de données
    * selectChampsFromTable() : crée une chaine contenant le début d'une requete select avec la liste des champs et le nom de la table correspondant à l'objet courant
    * whereCriteres($champsCriteres, $nb) : crée une chaine contenant les critères de selection (WHERE) d'une requete séparés par des AND
    * whereCriteresOU($champsCriteres, $nb) : idem avec séparation des critères par des OR
    * orderBy($tri) : crée une chaine contenant le moceau de requête permettant de trier les résultats obtenus (ORDER BY)
    * tableauParametres($champsCriteres) : crée le tableau des paramètres valorisés pour la requête 
    * traiteResultatSelectObjet($requete) : charge l'objet courant avec le résultat de la requête si il existe
    * traiteResultatSelectListe($requete) : renvoie une liste d'objet contenant le résultat de la requête
    * traiteReqListeObjets($sql, $param = []) : gère tout le traitement d'une requête de recherche de liste et renvoie une liste d'objets
    * traiteReqListeTabAssoc($sql, $param = []) : gère tout le traitement d'une requête de recherche de liste et renvoie un tableau association indexé sur l'id

    * listeCriteres($champsCriteres = [], $tri = [], $limite = "") : recherche une liste d'objets en fonction des critères de sélection donnés (on teste des égalités),  triée selon le champ et le sens donnés dans $tri 
    * listeCriteresOU($champsCriteres = [], $tri = [], $limite = "") : idem avec un whereCriteresOU
    * objetCriteres($champsCriteres) : charge l'objet courant avec la première ligne de la table respectant tous les critères donnés (test : égalités)
    * objetCriteresOU($champsCriteres) : charge l'objet courant avec la première ligne de la table respectant UN DES critères donnés (test : égalités)
    * listeDeroulante() : récupére un tableau associatif contenant pour chaque ligne la valeur du libellé indexée par l'id

    * creeDansBD() : crée un nouvel enregistrement dans la BD et récupère son id
    * modifieBD() : met à jour l'enregistrement correspondant à l'objet courant dans la BD

********************************************************************/

class baseObjet {


    ////////////////
    // PROPRIETES //
    ////////////////

    protected $champs = [];  // liste des champs hors id
    protected $table = "";   // nom de la table dans la BD
    protected $types = [];   // tableau indexé contenant les types correspondant à chaque champ (texte / nombre / lien / date)
    protected $liens = [];   // tableau des champs qui sont des liens vers une autre table (tableau indexé champ=>nomClasse)
    protected $libelle = []; // tableau contenant le champs composant le libellé

    protected $id = 0;       // valeur de l'id de l'objet (0 si l'objet n'est pas chargé)
    protected $valeurs = []; // tableau indexé contenant les valeurs des champs autres que l'id  


    /////////////////////////////////////////
    // METHODES DE MANIPULATION DES CHAMPS //
    /////////////////////////////////////////

    /****************/
    /* CONSTRUCTEUR */
    /****************/

    function __construct($id = 0)
    {
        // Role : constructeur : crée une instance de la classe, et la charge si un id est donné
        // Retour : un objet de la classe, vide ou chargé avec la ligne d'id donné en paramètre
        // Paramètres : $id, optionnel, l'id de la ligne à charger dans l'objet

        // si un paramètre est donné, charger l'objet avec la ligne de la table d'$id donné
        if ($id != 0) {
            $this->objetCriteres($id);
        }
    }

    /***********/
    /* GETTERS */
    /***********/

    function getId() {
        // Role : retourne la valeur de l'id (clé primaire de la table)
        // Retour : l'id de l'objet courant
        // Paramètres : aucun

        return $this->id;
    }

    function getValeur($nomChamp) {
        // Role : retourne la valeur "brute" du champ $nomChamp pour l'objet courant
        // Retour : la valeur du champ, ou "" si le champ n'existe pas dans le tableau des champs
        // Paramètres : $nomChamp, le nom du champ dont on veut la valeur

        if (in_array($nomChamp, $this->champs) and isset($this->valeurs[$nomChamp])) {
            // retourner sa valeur
            return $this->valeurs[$nomChamp];
        } else {
            // sinon retourner ""
            return "";
        }
    }

    function get($nomChamp) {
        // Role : retourne la valeur du champ dont le nom est passé en paramètre, en fonction de son type
        // Retour : la valeur du champ ou l'objet cible pour les liens
        //          par défaut 0 pour le nombre, "" pour les chaines, la date du jour pour les dates, un objet vide pour les liens
        //          false si le champ n'existe pas 
        // Paramètres : $nomchamp, le nom du champ dont on veut récupérer la valeur
    
        // si le champs existe, 
        if (in_array($nomChamp, $this->champs)) {
            // récupérer le type du champ
            $type = $this->types[$nomChamp];
            // si le champ a une valeur
            if (isset($this->valeurs[$nomChamp])) {
                // selon le type du champ, on renvoie une valeur différente :
                switch($type)
                 {
                    // si le champ est de type text ou nombre, on renvoie la valeur associée
                    case "texte" : //return $this->valeurs[$nomChamp]; 
                    case "nombre" : return $this->valeurs[$nomChamp];                  
                    // si le champ est un lien vers un autre objet, on renvoie l'objet cible
                    case "lien" : return $this->getObjetLien($nomChamp);
                    // si le champ est de type date, on renvoie sa valeur
                    case "date" : return $this->valeurs[$nomChamp];
                } 
            } else {
            // si le champs existe mais n'a pas de valeur on renvoie une valeur prédéfinie selon le type de champ   
                switch($type)
                {
                    // si le champ est de type text ou nombre, on renvoie la valeur
                    case "texte" : return "";
                    case "nombre" : return 0;                  
                    // si le champ est un lien vers un autre objet (id d'un autre objet, cad clé secondaire dans la BD), on renvoie l'objet cible
                    case "lien" : return $this->objetVideLien($nomChamp);
                    // si le champ est de type date, on renvoie un objet dateTime
                    case "date" : return date("Y-m-d");
                } 
            }  
        }     
        // si le champ n'existe pas
        return false;
    }

    function getLibelle() {
        // Rôle : renvoie une chaine contenant les valeurs des champs appartenant au tableau libelle
        // Retour : la chaine composée des champs du libellé
        // Paramètres : aucun

        $chaine = "";
        foreach ($this->libelle as $champ)
            $chaine .= $this->getValeur($champ)." ";
            
        return $chaine;    
    }

    function getObjetLien($nomChamp) {
        // Rôle : retourne l'objet pointé par le champ donné de l'objet courant
        // Retour : un objet correspondant à la classe donnée par le tableau des liens, chargé si le champ a une valeur, sinon vide,
        //          ou false si le champ ne pointe pas sur un objet
        // Paramètres : $nomChamp, nom du champ correspondant à l'objet à récupérer

        // créer un objet de la classe pointée par le lien
        $objet = $this->objetVideLien($nomChamp);

        // si le lien existe et si on a un id pour charger l'objet, on le charge
        if (($objet != false) and (isset($this->valeurs[$nomChamp]))) {
            $objet->objetCriteres($this->valeurs[$nomChamp]);
        }

        // on retourne $objet 
        return $objet;
    }

    function objetVideLien($nomChamp) {
        // Role : retourne un objet vide défini par l'objet sur lequel pointe le lien enregistré dans le tableau des champs
        // Retour : l'objet ou false si le champ n'apparait pas dans le tableau des liens
        // Paramètres : $nomchamp, le nom du champ dont on veut récupérer la valeur
    
        // si le champ n'apparait pas dans le tableau des liens, pas de lien défini, on renvoie false
        if (!isset($this->liens[$nomChamp])) {
            return false;
        }

        // récupérer le nom de la classe de l'objet à charger 
        $nomClasse = $this->liens[$nomChamp];
     
        // création de l'objet et renvoi
        return new $nomClasse();
    }


    /***********/
    /* SETTERS */
    /***********/

    function set($nomChamp, $valeur) {
        // Role : donne au champ dont le nom est passé en paramètre la valeur passée en paramètre
        // Retour : true si on a réussi, false sinon
        // Paramètres : $nomChamp, le champ auquel on veut attribuer une valeur
        //              $valeur, la valeur à attribuer

        // si le champ existe (nom dans le tableau $champs)
        if (in_array($nomChamp, $this->champs)) {
            // on enregistre la valeur donnée en paramètre dans le tableau des valeurs, à l'index nomChamp
            $this->valeurs[$nomChamp] = $valeur;
            // on renvoie true pour dire que l'affectation a réussi
            return true;
        } else {
            //sinon on renvoie false
            return false;
        }
    }

    
    /////////////////////
    // AUTRES METHODES //
    /////////////////////

    function chargeObjetDepuisTableau($tab) {
        // Role : charge l'objet courant avec les éléments du tableau indexé sur les champs passé en paramètre
        // Retour : aucun 
        // Paramètres : $tab, le tableau indexé

        // pour chaque champ de l'objet courant 
        foreach ($this->champs as $champ) {
            // si le tableau contient une valeur pour l'index correspondant à ce champ
            if (isset($tab[$champ])) {
                // on attribue cette valeur au champ correspondant dans l'objet courant
                $this->set($champ, $tab[$champ]);
            }
        }
    }


    ////////////////////////////
    // METHODES LIEES A LA BD //
    ////////////////////////////

    function prepareExecuteRequete($sql, $param) {
        // Role : prépare et exécute une requête SQL dans la base de données
        // Retour : la requete exécutée si la préparation et l'exécution ont réussi, false sinon
        // Paramètres : $sql, chaine, requête SQL 
        //              $param, tableau valorisant les paramètres :paramètre 
    
        global $bdd;
    
        // préparation de la requête
        $requete = $bdd->prepare($sql);
    
        // si il y a une erreur lors de la preparation
        if ($requete === false) {
            // renvoyer false
            return false;
        }
    
        // exécution de la requête
        $requete->execute($param);
    
        // retour 
        // si il y a une erreur lors de l'exécution
        if ($requete === false) {
            // renvoyer false
            return false;
        } else {
            //sinon renvoyer la requête exécutée
            return $requete;
        }
    }

    function selectChampsFromTable() {
        // Role : crée une chaine contenant le début d'une requete select avec la liste des champs 
        //          et le nom de la table correspondant à l'objet courant
        // Retour : la chaine contenant le début de la requête
        // Paramètres : aucun 

        // initialiser la chaine avec le début de la requête
        $sql = "SELECT `id`";
        // on ajoute la liste des champs en la récupérant dans le tableau $champs :
        // pour chaque champ du tableau
        foreach ($this->champs as $champ) {
            // on ajoute le nom du champ à la requête
            $sql .= ",`$champ`";
        }
        // on donne le nom de la table
        $sql .= " FROM `$this->table` ";

        return $sql;
    }

    function whereCriteres($champsCriteres, $nb) {
        // Role : crée une chaine contenant les critères de selection (WHERE) d'une requete séparés par des AND
        // Retour : la chaine créee
        // Paramètres : $champsCriteres, tableau indexé sur les noms des champs des valeurs recherchées
        //              $nb, entier, le nombre de critères de sélection à ajouter

        $criteres = " WHERE ";

        // initialiser un compteur pour voir combien de champs on a déjà traités
        $i = 1;
        foreach ($champsCriteres as $nomChamp => $valeurChamp) {
            $criteres .= " `$nomChamp` = :$nomChamp ";
            $param[":$nomChamp"] = $valeurChamp;
            // si ce n'est pas le dernier critère, on ajoute AND
            if ($i < $nb) {
                $criteres .= " AND ";
            }
            $i++;
        }

        return $criteres;
    }

    function whereCriteresOU($champsCriteres, $nb) {
        // Role : crée une chaine contenant les critères de selection (WHERE) d'une requete séparés par des OR
        // Retour : la chaine créee
        // Paramètres : $champsCriteres, tableau indexé sur les noms des champs des valeurs recherchées
        //              $nb, entier, le nombre de critères de sélection à ajouter

        $criteres = " WHERE ";

        // initialiser un compteur pour voir combien de champs on a déjà traités
        $i = 1;
        foreach ($champsCriteres as $nomChamp => $valeurChamp) {
            $criteres .= " `$nomChamp` = :$nomChamp ";
            $param[":$nomChamp"] = $valeurChamp;
            // si ce n'est pas le dernier critère, on ajoute OR
            if ($i < $nb) {
                $criteres .= " OR ";
            }
            $i++;
        }

        return $criteres;
    }

    function orderBy($tri) {
        // Role : crée une chaine contenant le morceau de requête permettant de trier les résultats obtenus (ORDER BY)
        // Retour : la chaine
        // Paramètres : $tri, tableau indexé sur un nom de champ avec pour valeur le sens à appliquer pour le tri

        // récupérer le champ et le sens de tri donnés dans le tableau $tri
        $champ = array_keys($tri)[0];
        $sens = $tri[$champ];

        // renvoyer la chaine à ajouter à la requête 
        return " ORDER BY $champ $sens ";
    }
 
    function tableauParametres($champsCriteres) {
        // Role : crée le tableau des paramètres valorisés pour la requête 
        // Retour : le tableau créé
        // Paramètres : $champsCriteres, tableau indexé sur les noms des champs des valeurs recherchées

        $param = [];

        // on ajoute chaque valeur au tableau des paramètres
        foreach ($champsCriteres as $nomChamp => $valeurChamp) {
            $param[":$nomChamp"] = $valeurChamp;
        }

        return $param;
    }

    function traiteResultatSelectObjet($requete) {
        // Role : charge l'objet courant avec le résultat de la requête si il existe
        // Retour : true si un résultat a été trouvé, false sinon
        // Paramètres : $requête, la requête préparée et exécutée dont on veut traiter le résultat

        // si la preparation et l'execution se sont bien passées, on récupère et on traite le résultat de la requête
        if ($requete != false) {
            // récupérer le résultat de la requête 
            $tab = $requete->fetch(PDO::FETCH_ASSOC);

            // si le tableau est vide, on renvoie false  
            if (empty($tab)) {
                return false;
            }

            // (sinon) on recupére les valeurs dans l'objet courant
            $this->id = $tab["id"];
            $this->chargeObjetDepuisTableau($tab);

            // on renvoie true pour indiquer qu'on a pu récupérer l'enregistrement cherché dans l'objet courant
            return true;
        }
        // sinon on renvoie false
        else 
            return false ;
    }

    function traiteResultatSelectListe($requete) {
        // Role : renvoie une liste d'objet contenant le résultat de la requête
        // Retour : la liste d'objets
        // Paramètres : $requête, la requête préparée et exécutée dont on veut traiter le résultat

        $liste = [];   

        // si la preparation et l'execution se sont bien passées, on récupère et on traite les résultats de la requête
        if ($requete != false) {

            // on récupère le nom de classe de l'objet  
            $nomClasse = get_class($this);

            // récupérer chaque résultat de la requête (tableau indexé), le transformer en objet, et l'ajouter à la liste
            while ($ligne = $requete->fetch(PDO::FETCH_ASSOC)) {
                // créer un objet
                $objet = new $nomClasse();

                // recupérer la ligne dans l'objet 
                $objet->id = $ligne["id"];
                $objet->chargeObjetDepuisTableau($ligne);

                // ajouter l'objet à la liste à renvoyer
                $liste[$ligne["id"]] = $objet;
            }
        }

        // renvoyer la liste (vide ou pleine selon les résultats de la requête)
        return $liste;
    }

    function traiteReqListeObjets($sql, $param = []) {
        // Rôle : gère tout le traitement d'une requête de recherche de liste et renvoie une liste d'objets
        // Retour : la liste d'objets
        // Paramètre : $sql, chaine contenant la requête
        //             $tab, le tableau des paramètre (optionnel si vide)

        // preparer et exécuter la requête
        $requete = $this->prepareExecuteRequete($sql, $param);

        // traiter le résultat de la requête et le renvoyer
        return $this->traiteResultatSelectListe($requete);
    }

    function traiteReqListeTabAssoc($sql, $param = []) {
        // Rôle : gère tout le traitement d'une requête de recherche de liste et renvoie un tableau association indexé sur l'id
        // Retour : le tableau associatif
        // Paramètre : $sql, chaine contenant la requête
        //             $tab, le tableau des paramètre (optionnel si vide)

        // preparer et exécuter la requête
        $requete = $this->prepareExecuteRequete($sql, $param);

        // récupérer le tableau résultat de la requête 
        $tabRes = $requete->fetchALL(PDO::FETCH_ASSOC);
//afRes($tabRes);

        // le transformer en tableau associatif
        $tab=[];
        foreach ($tabRes as $res) {
            $tab[$res['id']] = $res;
        }
//afRes($tab);

        return $tab;
    }

    /************************************/
    /*            RECHERCHE             */
    /************************************/

    function listeCriteres($champsCriteres = [], $tri = [], $limite = "") {
        // Role : recherche une liste d'objets en fonction des critères de sélection donnés (on teste des égalités),  triée selon le champ et le sens donnés dans $tri
        // Retour : la liste trouvée lors de la recherche
        // Paramètres (tous optionnels): 
        //              $champsCriteres, tableau indexé sur les noms des champs de valeurs recherchées 
        //              $tri, tableau indexé : nom du champ sur lequel on doit trier => le sens 
        //              $limite, le nombre d'enregistrements attendus

        // initialiser la requete select avec les champs et la table
        $sql = $this->selectChampsFromTable();

        // initialiser le tableau des paramètres à valoriser
        $param = [];

        // ajouter les critères de sélection si il y en a
        $nb = count($champsCriteres);
        if ($nb > 0) {
            // ajouter les critères de sélection à la requête
            $sql .= $this->whereCriteres($champsCriteres, $nb);
            // créer le tableau des paramètres correspondant
            $param = $this->tableauParametres($champsCriteres);
        }

        // ajouter le tri 
        if (!empty($tri)) {
            $sql .= $this->orderBy($tri);
        }    

        // ajouter le nombre de lignes max à renvoyer
        if ($limite != "") {
            $sql.= " LIMIT $limite ";
        }    
        
        // preparer et exécuter la requête
        $requete = $this->prepareExecuteRequete($sql, $param);

        // traiter le résultat de la requête et le renvoyer
        return $this->traiteResultatSelectListe($requete);
    }

    function listeCriteresOU($champsCriteres = [], $tri = [], $limite = "") {
        // Role : récupére une liste d'objets en fonction des critères de sélection donnés (on teste des égalités), triée selon le champ et le sens donnés dans $tri
        // Retour : la liste trouvée lors de la recherche
        // Paramètres (tous optionnels): 
        //              $champsCriteres, tableau indexé sur les noms des champs de valeurs recherchées 
        //              $tri, tableau indexé : nom du champ sur lequel on doit trier => le sens 
        //              $limite, le nombre d'enregistrements attendus


        // initialiser la requete select avec les champs et la table
        $sql = $this->selectChampsFromTable();

        // initialiser le tableau des paramètres à valoriser
        $param = [];

        // ajouter les critères de sélection si il y en a
        $nb = count($champsCriteres);
        if ($nb > 0) {
            // ajouter les critères de sélection à la requête
            $sql .= $this->whereCriteresOU($champsCriteres, $nb);
            // créer le tableau des paramètres correspondant
            $param = $this->tableauParametres($champsCriteres);
        }

        // ajouter le tri 
        if (!empty($tri)) {
            $sql .= $this->orderBy($tri);
        }    

        // ajouter le nombre de lignes max à renvoyer
        if ($limite != "") {
            $sql.= " LIMIT $limite ";
        }    
echo $sql;        
        // preparer et exécuter la requête
        $requete = $this->prepareExecuteRequete($sql, $param);

        // traiter le résultat de la requête et le renvoyer
        return $this->traiteResultatSelectListe($requete);
    }


    function objetCriteres($champsCriteres) {
        // Role : charge l'objet courant avec la première ligne de la table respectant tous les critères donnés (test : égalités)
        // Retour : true si un objet a été récupéré, false sinon
        // Paramètres : $champsCriteres, tableau indexé sur les noms des champs de valeurs à tester 

        // si on a un paramètre simple au lieu d'un tableau de paramètre, c'est un id
        if (!is_array($champsCriteres)) 
            $champsCriteres = [ "id" =>$champsCriteres];

        // initialiser la requete select avec les champs et la table
        $sql = $this->selectChampsFromTable();

        // initialiser le tableau des paramètres à valoriser
        $param = [];

        // compter les critères de sélection
        $nb = count($champsCriteres);
        // ajouter les critères de sélection à la requête
        $sql .= $this->whereCriteres($champsCriteres, $nb);
        // créer le tableau des paramètres correspondant
        $param = $this->tableauParametres($champsCriteres);

        // preparer et exécuter la requête
        $requete = $this->prepareExecuteRequete($sql, $param);

        // traiter le résultat de la requête et le renvoyer
        return $this->traiteResultatSelectObjet($requete);
    }

    function objetCriteresOU($champsCriteres) {
        // Role : charge l'objet courant avec la première ligne de la table respectant UN DES critères donnés (test : égalités)
        // Retour : true si un objet a été récupéré, false sinon
        // Paramètres : $champsCriteres, tableau indexé sur les noms des champs de valeurs à tester 

        // si on a un paramètre simple au lieu d'un tableau de paramètre, c'est un id
        if (!is_array($champsCriteres)) 
            $champsCriteres = [ "id" =>$champsCriteres];

        // initialiser la requete select avec les champs et la table
        $sql = $this->selectChampsFromTable();

        // initialiser le tableau des paramètres à valoriser
        $param = [];

        // compter les critères de sélection
        $nb = count($champsCriteres);
        // ajouter les critères de sélection à la requête
        $sql .= $this->whereCriteresOU($champsCriteres, $nb);
        // créer le tableau des paramètres correspondant
        $param = $this->tableauParametres($champsCriteres);

        // preparer et exécuter la requête
        $requete = $this->prepareExecuteRequete($sql, $param);

        // traiter le résultat de la requête et le renvoyer
        return $this->traiteResultatSelectObjet($requete);
    }

    function listeDeroulante() {
        // Role : récupére un tableau associatif contenant pour chaque ligne la valeur du libellé indexée par l'id
        // Retour : la liste trouvée lors de la recherche
        // Paramètres : aucun        

        // création de la requête
        $sql = "SELECT `id`";
        // on ajoute la liste des champs en la récupérant dans le tableau $libelle :
        // pour chaque champ du tableau
        foreach ($this->libelle as $champ) {
            // on ajoute le nom du champ à la requête
            $sql .= ",`$champ`";
        }
        // on donne le nom de la table
        $sql .= " FROM `$this->table` ";

        // preparer et exécuter la requête
        $requete = $this->prepareExecuteRequete($sql, []);

        // récupérer le tableau résultat de la requête 
        $tabRes = $requete->fetchALL(PDO::FETCH_ASSOC);

        // le transformer en tableau asociatif
        $tab=[];

        foreach ($tabRes as $res) {
            $chaine = "";
            foreach ($this->libelle as $champ)
                $chaine .= $res[$champ]." ";
            $tab[$res["id"]] = $chaine; 
        }

        return $tab;
    }


    /**********************************************/
    /*         MODIFICATION DE LA TABLE           */
    /**********************************************/

    function creeDansBD() {
        // Role : crée un nouvel enregistrement dans la BD et récupère son id
        // Retour : l'id du nouvel identifiant ou 0 si l'enregistrement n'a pas pu être créé
        // Paramètres : aucun

        // on aura besoin de connaitre la variable globale pour récupérer l'id de l'enregistrement créé
        global $bdd;

        // creation de la requête
        // - début
        $sql = "INSERT INTO `$this->table` ";

        // - ajout des champs et de leur valeur
        // initialisation de la chaine contenant la liste des champs
        $listeChamps = "";
        // initialisation de la chaine contenant la liste des valeurs
        $listeValeurs = "";
        // initialiser le tableau des paramètres
        $param = [];

        // construire les chaines et le tableau des paramètres
        foreach ($this->champs as $champ) {
            $listeChamps .= " `$champ`,";
            $listeValeurs .= " :$champ,";
            $param[":$champ"] = $this->valeurs[$champ];
        }
        // enlever la dernière "," à la fin des chaines
        $listeChamps = substr($listeChamps, 0, -1);
        $listeValeurs = substr($listeValeurs, 0, -1);

        // compléter la requête
        $sql .= " ($listeChamps) VALUES ($listeValeurs)";

        // preparer et exécuter la requête
        $requete = $this->prepareExecuteRequete($sql, $param);

        // si requete = false, l'enregistrement n'a pas pu être créé, on retourne 0
        if ($requete == false) {
            return 0;
        }

        // (sinon) récupérer l'id du nouvel enregistrement
        $id = $bdd->lastInsertId();

        // renvoyer l'id
        return $id;
    }

    function modifieBD() {
        // Role : met à jour l'enregistrement correspondant à l'objet courant dans la BD
        // Retour : true si on a réussi la modification, false sinon
        // Paramètres : aucun

        // construction de la requête et du tableau des paramètres
        // debut de la requête
        $sql = "UPDATE `$this->table` SET ";

        // initialisation du tableau des paramètres
        $param = [];

        // pour chaque champ du tableau
        foreach ($this->champs as $champ) {
            // on enregistre l'égalité $champ=:champ dans la requête
            $sql .= "`$champ`=:$champ";
            // on ajoute une virgule si ce n'est pas le dernier champ traité (celui qui correspond à l'index nb d'élmt-1)
            if ($champ != $this->champs[count($this->champs) - 1]) {
                $sql .= ",";
            }

            // on enregistre la valeur du champ à l'index correspondant au nom du champ à valoriser :champ
            $param[":$champ"] = $this->valeurs[$champ];
        }

        // fin de la requête et ajout de l'id au tableau des paramètres
        $sql .= " WHERE `id`=:id";
        $param[":id"] = $this->getId();

        // preparer et exécuter la requête 
        $requete = $this->prepareExecuteRequete($sql, $param);

        // renvoyer le résultat ($requete = false ou le résultat de l'exécution si elle a réussi)
        if ($requete == false) {
            return false;
        } else {
            return true;
        }
    }

}