<?php 
/*
    Template de fragment : formulaire de saise d'un nouveau projet
    Paramètres : aucun 
*/

?>
<div class="large-70 text-center">
<form action="creer_projet.php" method="post">
    <fieldset>
        <div class="flex justify-between">
            <div class="large-30 text-end">
                <label> Titre : </label>    
            </div>
            <div class="large-70">
                <input type="text" name="titre" required>
            </div>   
            <div class="large-30 text-end">     
                <label> Description : </label>
            </div>    
            <div class="large-70">     
                <textarea name="description" rows="3" required></textarea>
            </div>    
            <div class="large-30 text-end">     
                <label> Montant demandé : </label> 
            </div>    
            <div class="large-70">     
                <input type="number" step=1 min=0 max=100000 name="montant" required>
            </div>    
            <div class="large-30 text-end">     
                <label> Email : </label> 
            </div>    
            <div class="large-70">     
            <input type="email" name="email" required>
        </div>    
        <div class="large-100">     
            <label> J'ai déjà enregistré un projet et je veux réutiliser <br>les coordonnées associées à cette adresse mail         </label>     
            <select name="affich_suite" id="affich_suite">
                <option value="non" selected>NON</option>
                <option value="oui">OUI</option>
            </select>
        </div>
    </fieldset>
<!-- tester si email existe dans BD pour proposer de réutiliser les valeurs -->
    <fieldset id="suiteform">
        <div class="flex justify-between">
            <div class="large-30 text-end">     
                <label> Nom : </label> 
            </div>
            <div class="large-70">     
                <input type="text" name="nom">
            </div>    
            <div class="large-30 text-end">     
                <label> Prénom : </label>
            </div>    
            <div class="large-70">     
                <input type="text" name="prenom">
            </div>
            <div class="large-30 text-end">     
                <label> Adresse : </label>
            </div>    
            <div class="large-70">     
                <input type="text" name="adresse">
            </div>    
            <div class="large-30 text-end">     
                <label> Téléphone : </label>    
            </div>    
            <div class="large-70">     
                <input type="text" name="telephone">
            </div>    
        </div>
    </fieldset>   
    <fieldset>
        <input type="submit" value="Proposer ce projet">
    </fieldset>     

</form>
</div>