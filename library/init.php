<?php
/*
    Fichier d'initialisations diverses 
*/

// gestion des erreurs et affichage des messages d'erreur
ini_set('display_errors', 1); // affichage des erreurs à l'écran pour debug
error_reporting(E_ALL); // signaler et afficher tous les types d'erreur

// chargement des librairies 
include_once "config/config.php"; // fichier de configuration à part pour le faire gérer par .gitignore et .htaccess
include_once "library/mesFonctions.php"; // fonctions php hors méthodes objets
include_once "library/baseObjet.php"; // objet modèle de base dont héritent les objets liés aux tables de la BD

// autoload pour les classes 
spl_autoload_register(function ($class_name) {
    // mettre le nom du fichier correspondant à la classe dans la variable $file 
    $file = 'data/' . $class_name . '.php';
    // si ce fichier = cette classe existe
    if (file_exists($file)) {
        // on le charge
        include_once $file;
    }
});

// initialisation d'une session
session::start(); 

// initialisation de la base de données
$bdd = new PDO(
                "mysql:host=$serveur;dbname=$baseDonnees;charset=UTF8",
                $identifiant,
                $mp
               );

// affichage des erreurs liées à la base de données
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);