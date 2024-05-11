<?php

/***************************************/
/*         Classe : financement        */
/***************************************/

/*******************************************************************
    Méthodes disponibles : 

    * Toutes les méthodes héritées de la classe library/baseObjet
   +
    * promessesFinancement($id_membre) : trouver la liste des financements promis par le membre d'id donné avec les détails du projet
 
********************************************************************/

class financement extends baseObjet {

    ////////////////
    // PROPRIETES //
    ////////////////

    protected $champs = ["projet","membre","montant"]; // liste des champs hors id
    protected $table = "financement";  // nom de la table dans la BDD
    protected $liens = ["projet"=>"projet","membre"=>"membre"];
    protected $types = ["projet"=>"lien","membre"=>"lien","montant"=>"nombre"]; // types : "lien","texte","nombre","date"

    /////////////////////////////////////
    // METHODES EXCLUSIVES A LA CLASSE //
    /////////////////////////////////////

    function promessesFinancement($id_membre) {
        // Rôle : trouver la liste des financements promis par le membre d'id donné avec les détails du projet
        // Retour : la liste trouvée (tableau associatif)
        // Paramètres : $id_membre, l'id du membre concernné par la recherche

        // preparer la requete
        $sql = "SELECT `projet`.`id` AS 'id_projet',`projet`.`titre`, `projet`.`description`, 
        `projet`.`montant` as 'total', `projet`.`statut`, `projet`.`date`, `financement`.`montant`
        FROM `financement` LEFT JOIN  `projet`
        ON `financement`.`projet` = `projet`.`id`
        WHERE `financement`.`membre` = :id_membre
        AND `projet`.`statut` = 'valide'";
        $param = [":id_membre" =>$id_membre];

        // preparer et exécuter la requête
        $requete = $this->prepareExecuteRequete($sql, $param);

        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }
}