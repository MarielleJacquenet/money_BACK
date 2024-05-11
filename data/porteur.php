<?php

/***********************************/
/*         Classe : porteur        */
/***********************************/

/*******************************************************************
    Méthodes disponibles : 

    * Toutes les méthodes héritées de la classe library/baseObjet

********************************************************************/

class porteur extends baseObjet {

    ////////////////
    // PROPRIETES //
    ////////////////

    protected $champs = ["nom","prenom","email","adresse","telephone"]; // liste des champs hors id
    protected $table = "porteur";  // nom de la table dans la BDD
    protected $types = ["nom"=>"texte","prenom"=>"texte","email"=>"texte","adresse"=>"texte","telephone"=>"texte"]; // types : "lien","texte","nombre","date"
    protected $libelle = ["nom","prenom"]; // liste des champs du libellé

    /////////////////////////////////////
    // METHODES EXCLUSIVES A LA CLASSE //
    /////////////////////////////////////


}