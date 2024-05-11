<?php 
/*
    Template de fragment : lien vers la page d’accueil, et boutons en fonction de la connexion et du rôle de l'utilisateur connecté (simple membre ou gestionnaire)

    Paramètres : aucun (infos utiles dans la session)
*/
?>

<header>
    <nav class="flex justify-between align-center">
        <a href="index.php" class="logo">MONEY</a>

        <?php if (session::connexion()) { 
                echo "Bonjour ".session::get("pseudo");
                if ((session::get("role") == "gestionnaire") and (session::get("role_courant") == "gestionnaire")) {
        ?>        
                    <a href="gerer_membres.php"><button>Gérer les membres</button></a>
                    <a href="rechercher_liste.php?action=1"><button>Projets en attente de validation</button></a>
                    <a href="rechercher_liste.php?action=2"><button>Détails des projets acceptés</button></a>
                    <a href="index.php?role=membre"><button>Me connecter comme simple membre</button></a>
                <?php } 
                if ((session::get("role") == "membre") or (session::get("role_courant") == "membre")) {
                ?>
                    <a href="rechercher_liste.php?action=3"><button>Mes promesses de financement</button></a>
                    <a href="rechercher_liste.php?action=4"><button>Projets en attente de financement</button></a>
                    <a href="rechercher_liste.php?action=6"><button>Mes projets financés</button></a>
                    <a href="rechercher_liste.php?action=5"><button>Tous les projets financés par MONEY</button></a>
                    <?php
                    if (session::get("role") == "gestionnaire") { 
                    ?>
                        <a href="index.php?role=gestionnaire"><button>Me connecter comme gestionnaire</button></a>
                    <?php
                    }
                } ?>
                <div>
                    <a href="deconnecter.php"><button>Déconnecter</button></a>
                </div>
        <?php } 
        else { ?>
                <div class="flex align-center">
                    <form action="connecter.php" method="post">
                        <input type="text" name="login" placeholder=" pseudo ou email">
                        <input type="password" name="mp" placeholder="mot de passe">
                        <input type="submit" value="Connecter">
                    </form>
                </div>
        <?php } ?>
    </nav>
</header>