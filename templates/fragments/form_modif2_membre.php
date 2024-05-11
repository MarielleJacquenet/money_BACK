<?php 
/*
    Template de fragment : formulaire de modification d'un profil de membre, préchargé avec les infos du membre données, sauf mot de passe
    Paramètres : $membre, le membre à modifier 
*/

?>

<form action="modifier_profil.php?id=<?=$membre->getId() ?>" method="post">
    <label> Pseudo
        <input type="text" name="pseudo" value=<?= htmlentities($membre->get("pseudo"))?>>
    </label>
    <label> Email
        <input type="email" name="email" value=<?= htmlentities($membre->get("email"))?>>
    </label>
    <label>
        <input type="password" name="mp">
    </label>
    <label> Répétez le mot de passe
        <input type="password" name="mp2">
    </label>
    <label> Nom
        <input type="text" name="nom" value=<?= htmlentities($membre->get("nom"))?>>
    </label>
    <label>Prénom
        <input type="text" name="prenom" value=<?= htmlentities($membre->get("prenom"))?>>
    </label>
    <label> Code postal
        <input type="text" name="cp" value=<?= htmlentities($membre->get("cp"))?>>
    </label>
    <label> Rôle 
        <select name="role">
            <option value="membre" 
                <?php if ($membre->get("role") == "membre") 
                    echo " selected ";?>
            >Membre simple</option>
            <option value="gestionnaire"
                <?php if ($membre->get("role") == "gestionnaire") 
                    echo " selected ";?>
            >Gestionnaire</option>
        </select>    
    </label>
    <input type="submit" value="Créer ce profil">
</form>
