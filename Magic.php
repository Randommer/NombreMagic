<?php
    //initialisation de la session
    session_start();
    //création d'un tableau associatif avec les variables dont le jeu à besoin (dont le nombre à trouver)
    $TableauVariables = array("MagiqueN" => random_int(1, 100), "Min" => 0, "Max" => 101, "Tentatives" => 0);
    //vérification si une session a déjà été initialisée (donc si une partie est déjà commencée)
    if (isset($_SESSION["MagicTab"]))
    {
        //mettre les variables de la session existante dans la tableau, pour les traiter dans le reste de la page
        $TableauVariables = $_SESSION["MagicTab"];
    }
    //on initialise une variable à faux, on la changera si la tentative correspond au nombre à trouver
    $gagne = false;
    //série de tests à effectuer si un post à effectuer pour arriver sur cette page
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //vérifie si une variable "again" est passé dans le post (donc le joueur a cliqué sur Nouvelle Partie)
        if (!empty($_POST["again"]))
        {
            //création d'un nouveau tableau associatif pour la nouvelle partie
            $TableauVariables = array("MagiqueN" => random_int(1, 100), "Min" => 0, "Max" => 101, "Tentatives" => 0);
        }
        else //si il n'y a pas de variable "again" dans le post (le joueur a donc effectué une tentative)
        {
            //on incrémente de 1 le nombre de tentatives que le joueur a testé 
            $TableauVariables["Tentatives"]++;
            //on vérifie si la variable "essai" (qu'a rentré le joueur) est le nombre à trouver
            if ($_POST["essai"] == $TableauVariables["MagiqueN"])
            {
                //C'est gagné !!
                //on change la variable à vrai qui servira à afficher l'écran de victoire
                $gagne = true;
            }
            else //si l'essai pas n'est pas le nombre à trouver
            {
                //on test si l'essai est plus grand que le nombre à trouver
                if ($_POST["essai"] > $TableauVariables["MagiqueN"])
                {
                    //on change la valeur limite haute de la plage où se trouve le nombre à trouver
                    $TableauVariables["Max"] = $_POST["essai"];
                }
                else //si l'essai n'est pas plus grand, donc il est plus petit
                {
                    //on change la valeur limite basse de la plage où se trouve le nombre à trouver
                    $TableauVariables["Min"] = $_POST["essai"];
                }
            }
        }
    }
    //on enregistre les nouvelles variables dans la session
    $_SESSION["MagicTab"] = $TableauVariables;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- CSS des icons Font Awesome -->
    <link href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" rel="stylesheet" crossorigin="anonymous">
    <title>Nombre Magique</title>
    
</head>
<body>
    <div class="container">
        <!-- Titre H1 de la page -->
        <div class="row">
            <h1 class="col-12 offset-lg-3 col-lg-6 text-center font-weight-bold">Le Nombre Magique</h1>
        </div>
        <?php
            //code HTML à afficher si la partie est gagnée
            if ($gagne)
            {
        ?>
            <!-- écran de victoire, qui affiche le nombre trouvé et le nombre de tentatives que le joueur a tenté -->
            <div class="row">
                <div class="offset-1 col-10 offset-md-2 col-md-8 offset-lg-4 col-lg-4 alert alert-success">
                    <h2 class="text-success font-weight-bold text-center"><i class="fas fa-trophy"></i> BRAVO <i class="fas fa-trophy"></i></h2>
                    <p>C'est gagné !!<br></p>
                    <p><?php echo $TableauVariables["MagiqueN"]; ?> était bien le nombre magique.<br></p>
                    <p>Vous avez trouvé en <?php echo $TableauVariables["Tentatives"]; ?> tentatives.</p>
                </div>
            </div>
            <!-- formulaire pour lancer une nouvelle partie -->
            <div class="row">
                <form action="" method="POST" class="offset-1 col-10 offset-md-2 col-md-8 offset-lg-4 col-lg-4" validate>
                    <div class="form-group">
                        <!-- on met un champ hidden "again" pour que l'algorithme crée une nouvelle partie -->
                        <input type="hidden" name="again" id="again" value="letsgo" required>
                        <button type="submit" class="btn btn-info btn-block" autofocus>
                            <i class="fas fa-dice"></i> Nouvelle Partie
                        </button>
                    </div>
                </form>
            </div>
        <?php
            //on nettoie la session car la partie est gagnée
            //on vide les variables de la session
            $_SESSION = array();
            //on supprime le cookie de la session
            if (ini_get("session.use_cookies")) 
            {
                setcookie(session_name(), '', time()-42);
            }
            //on détruit la session
            session_destroy();
        }else{ //code à afficher à quand une partie commence ou est en cours
            //création d'une chaîne de caractères qui servira d'expression régulière pour que le joueur ne puisse entrer que les nombres dans la plage du nombre à trouver
            //on ouvre la chaîne avec une ouverture de parenthèse puis le premier nombre de la plage du nombre à trouver
            $ExReg = "(".($TableauVariables["Min"] + 1);
            //on fait tourner une boucle pour chaque nombre suivant dans la plage du nombre à trouver
            for ($i = $TableauVariables["Min"] + 2; $i <= $TableauVariables["Max"] - 1; $i++)
            {
                //on concatène la chaîne existante avec le caractère |, suivi du nombre du tour de boucle
                $ExReg = $ExReg."|".$i;
            }
            //on concatène la chaîne existante avec une fermeture de parenthèse
            $ExReg = $ExReg.")";
            ?>
            <!-- écran d'informations, il indique la plage du nombre à trouver -->
            <div class="row">
                <div class="offset-2 col-8 offset-md-3 col-md-6 offset-lg-4 col-lg-4 alert alert-warning">
                    <h2 class="text-center font-weight-bold">
                        <?php //affichage de la valeur limite basse
                        //si la limite basse est celle de défaut, on affiche 1 avec ≤
                        if ($TableauVariables["Min"] == 0) { ?>
                            1
                            <i class="fas fa-less-than-equal"></i>
                        <?php } else {
                        //sinon on affiche la limite basse avec <
                            echo $TableauVariables["Min"]; ?>
                            <i class="fas fa-less-than"></i>
                        <?php } ?>
                        <i class="fas fa-question"></i>
                        <?php //affichage de la valeur limite haute
                        //si la limite haute est celle de défaut, on affiche ≤ avec 100
                        if ($TableauVariables["Max"] == 101) { ?>
                            <i class="fas fa-less-than-equal"></i>
                            100
                        <?php } else {
                        //sinon on affiche < avec la limite haute ?>
                            <i class="fas fa-less-than"></i>
                            <?php echo $TableauVariables["Max"];
                        } ?>
                    </h2>
                </div>
            </div>
            <!-- formulaire pour proposer un nombre -->
            <div class="row">
                <form action="" method="POST" class="offset-1 col-10 offset-md-2 col-md-8 offset-lg-4 col-lg-4 alert alert-info" validate>
                    <div class="form-group text-center">
                        <label for="essai">Vous proposez ?</label>
                        <input type="tel" name="essai" id="essai" pattern="<?php echo $ExReg; ?>" minlength="1" maxlength="3" class="form-control" autocomplete="off" autofocus required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-warning btn-block font-weight-bold">
                            <i class="fas fa-hand-sparkles"></i> Essayer
                        </button>
                    </div>
                </form>
            </div>
            <!-- formulaire pour lancer une nouvelle partie -->
            <div class="row">
                <form action="" method="POST" class="offset-1 col-10 offset-md-2 col-md-8 offset-lg-4 col-lg-4" validate>
                    <div class="form-group">
                        <!-- on met un champ hidden "again" pour que l'algorithme crée une nouvelle partie -->
                        <input type="hidden" name="again" id="again" value="letsgo" required>
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-dice"></i> Nouvelle Partie
                        </button>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>




    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>