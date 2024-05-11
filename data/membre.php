<?php

/**********************************/
/*         Classe : membre        */
/**********************************/

/*******************************************************************
    Méthodes disponibles : 

    * Toutes les méthodes héritées de la classe library/baseObjet

********************************************************************/

class membre extends baseObjet {

    ////////////////
    // PROPRIETES //
    ////////////////

    protected $champs = ["pseudo","email","mp","nom","prenom","cp","statut","role"]; // liste des champs hors id
    protected $table = "membre";  // nom de la table dans la BDD
    protected $types = ["pseudo"=>"texte","email"=>"texte","mp"=>"texte","nom"=>"texte","prenom"=>"texte","cp"=>"nombre","statut"=>"texte","role"=>"texte"]; // types : "lien","texte","nombre","date"
    protected $libelle = ["nom","prenom"]; // liste des champs du libellé

    /////////////////////////////////////
    // METHODES EXCLUSIVES A LA CLASSE //
    /////////////////////////////////////


}