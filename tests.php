<?php 
/*
    tests divers
    Paramètres : aucun
*/


include "library/init.php";

/////////////////////////////////////////////////////////////
// remplir table membres
/*
$membre = new membre();
$membre->set("email", "mama@mama.fr");
$membre->set("pseudo", "mama");
$membre->set("mp", password_hash("mama", PASSWORD_DEFAULT));
$membre->set("nom", "Cémoi");
$membre->set("prenom", "Marie");
$membre->set("cp", "42170");
$membre->set("role", "membre");
$membre->set("statut", "actif");

$id = $membre->creeDansBD();

echo "Ligne $id créée<br>";
*/
///////////////////////////////////////////////////////////////
// tests connexion

/* OK
$membre = new membre();
$membre->objetCriteres(1);
afRes($membre);
*/
/* OK
afRes($_SESSION);
if (session::connexion()) 
    echo "connecte<br>";
else
    echo "pas de connexion en cours<br>";

session::connecter("toto","toto");
afRes($_SESSION);

session::modifRoleConnecte("membre");
afRes($_SESSION);

session::deconnecter();
afRes($_SESSION);
*/

/* OK
session::connecter("toto","toto");
afRes();

$uConnect = session::getMembreConnecte();
afRes($uConnect);
*/
////////////////////////////////////////////////////////////////
// test recherche liste

//$projet = new projet();

//$liste = $projet->listeCriteres(["statut" => "valide"],["date" => "DESC"],5);
//$liste = $projet->listeCriteres(["statut" => "attente"],["date" => "DESC"]);
//$liste = $projet->listeValideResteAFinancer(); 

//$liste = $projet->listeCriteresOU(["statut" => "valide", "statut" => "finance"],["date" => "DESC"]);
// PB cause 2 fois le même champ => refaire une fonction dédiée

//$financement = new financement();

//$liste = $financement->promessesFinancement(1);
// $liste = $financement->listeCriteres(["membre" => 1],["id" => "DESC"]);

//afRes($liste);

/////////////////////////////////////////////////////////////////
/*
$id_projet = 9;
$action = 3;

if ($action == 3)  { 
    echo "action 3 ";
    $proj = new projet($id_projet); 
    // récupération des informations sous forme de tableau indexé
    $projet = $proj->detailsProjetAFinancer();
    if (empty($projet)) {
        echo "tableau vide";
    }
    else 
        afRes($projet);
*/
/* 
Array
(
    [id] => 
    [titre] => 
    [description] => 
    [montant] => 
    [reste] => 
)
=> $projet jamais vide
*/
/*
 } 
elseif ($action == 4) {
    echo "action 4";
    // créer une instance de projet chargée pour l'id donné
    $projet = new projet($id_projet); 
    afRes($projet);
        }

*/
////////////////////////////////////////////////////////////
/*
$projet = new projet(9);

echo $projet->montantPromis(1);
echo $projet->montantRestantAFinancer();
*/
////////////////////////////////////////////////////////////
// test liste deroulante membres
/*
$membre = new membre();

$liste= $membre->listeDeroulante();
afRes($liste);
*/
/////////////////////////////////////////////////////////
// test foreach tableau vide
/*
$tab = [];
$trouve = 0;
foreach ($tab as $elem)
    $trouve = 1;
echo $trouve;
*/
/*
// test existe_nonvide($tabGet,$tabPost)
// echo true; echo false; // => affiche 1  => false renvoie chaine vide !!!
if (!existe_nonvide(["id"],[]))
    echo "pb !";
  else
   echo "paramètres ok";
*/

/////////////////////////////////////////////////
// test expressions régulières PHP
/*
$cp = 12345;
if(preg_match("/^[0-9]{5}$/",$cp)) {
    echo "Code postal OK";
} else {
    echo "Le code postal est invalide";
}
*/