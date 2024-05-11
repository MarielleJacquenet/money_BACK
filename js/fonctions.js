// appel toutes les 10s à la fonction maj_montant
setInterval(maj_montant, 10000);

// écouteur d'évènement sur la liste déroulante OUI/NON d'id #suiteform
$(document).ready(function() {
    $('#affich_suite').change(function() {
      maj_form_projet();
    });
})      

function maj_montant () {
    // Rôle : appel ajax  au controleur php qui recherche le montant restant à financer
    // Retour : aucun (affichage)
    // Paramètres : aucun (on récupère la valeur du data-id enregistré dans le DOM)

    // récupérer la valeur de data-idprojet
    let id_projet = $('body').data('idprojet');       

    // Envoyer la requête pour mettre à jour le montant financé
    $.ajax({
        url: "rechercher_montant.php", 
        type: "POST",
        data : {id: id_projet},  
        success: afficher_montant,
        error: function() { 
            console.error("Erreur de commnunication")
        },
    });

    // Pas d'affichage d'attente car on a l'affichage précédent en attendant    
}

function afficher_montant (valeur) {
    // Rôle : modifie l'affichage de l'élément HTML d'id #montant avec la valeur récupérée
    // Retour : aucun (affichage)
    // Paramètres : valeur, la valeur à afficher

    $("#montant").html(valeur);

}

function maj_form_projet () {
    // Rôle : rend visible la suite du formulaire si NON sélectionné
    // Retour : aucun
    // Paramètres : aucun

    // récupérer la valeur de l'option value sélectionnée
    let valeurOption = $('#affich_suite option:selected').val();

    // si l'option value sélectionnée est "oui"
    if (valeurOption == 'non') {
        // afficher la fin du formulaire (le fieldset d'id suiteform)
        $('#suiteform').css('display', 'block');  
    } else {
        // sinon cacher la fin du formulaire
        $('#suiteform').css('display', 'none');   
    }
}
