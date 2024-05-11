<?php 
/*
    Template de fragment : formulaire de creation d'un nouvau membre
    Paramètres : aucun
*/

?>

<form action="inscrire.php" method="post">
    <fieldset>
        <div class="flex justify-between">
            <div class="large-30 text-end">
                <label> Pseudo</label>
            </div>
            <div class="large-70">
                <input type="text" name="pseudo" required>
            </div>    
            <div class="large-30 text-end">
                <label> Email</label>
            </div>
            <div class="large-70">            
                <input type="email" name="email" required>
            </div>    
            <div class="large-30 text-end">            
                <label> Mot de passe</label>
            </div>
            <div class="large-70">
                <input type="password" name="mp" required>
            </div>    
            <div class="large-30 text-end">        
                <label> Répétez le mot de passe</label>
            </div>
            <div class="large-70">        
                <input type="password" name="mp2" required>
            </div>    
            <div class="large-30 text-end">        
                <label> Nom</label>
            </div>
            <div class="large-70">         
                <input type="text" name="nom" required>
            </div>    
            <div class="large-30 text-end">        
                <label>Prénom</label>
            </div>
            <div class="large-70">        
                <input type="text" name="prenom" required>
            </div>    
            <div class="large-30 text-end">        
                <label> Code postal</label>
            </div>
            <div class="large-70">        
                <input type="text" name="cp" required>
            </div>    
            <div class="large-30 text-end">        
                <label> Rôle </label>
            </div>
            <div class="large-70">        
                <select name="role">
                    <option value="membre" selected>Membre simple</option>
                    <option value="gestionnaire">Gestionnaire</option>
                </select>    
            </div>   
        </div>    
    </fieldset>   
    <fieldset>                 
        <input type="submit" value="Créer ce profil">
    </fieldset> 
</form>
