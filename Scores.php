<?php
    //on initialise deux variables 
    $Joueur1 = 0;
    $Joueur2 = 0;
    //manipulations à effectuer sur les variables si un post est effectué pour arriver sur cette page
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //vérifie si une variable "zero" n'est pas passé dans le post (donc l'utilisateur n'a pas cliqué sur bouton de remise à zéro)
        if (empty($_POST["zero"]))
        {
            //on récupère les valeurs post et elles remplacent les variables
            $Joueur1 = $_POST["joueur1"];
            $Joueur2 = $_POST["joueur2"];
            //on vérifie si une valeur "win1" existe
            if (!empty($_POST["win1"]))
            {
                //on incrémente de 1 la variable Joueur1
                $Joueur1++;
            }
            //on vérifie si une valeur "win2" existe
            if (!empty($_POST["win2"]))
            {
                //on incrémente de 1 la variable Joueur2
                $Joueur2++;
            }
        }
    }
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
    <title>Scores</title>
    
</head>
<body>
    <div class="container">
        <!-- Titre H1 de la page -->
        <div class="row">
            <h1 class="col-12 offset-xl-4 col-xl-4 text-center font-weight-bold">Scores</h1>
        </div>
        <!-- Sous-titre H2 de la page -->
        <div class="row">
            <h2 class="col-12 offset-xl-4 col-xl-4 text-center text-muted">Multijoueur</h2>
        </div>
        <div class="row">
            <!-- Encadré qui affiche le score du Joueur 1 et avec formulaire qui demande à l'algorithme de d'incrémenter son score -->
            <div class="col-6 offset-md-2 col-md-4 offset-xl-4 col-xl-2 alert alert-primary">
                <h3 class="text-primary font-weight-bold text-center"><i class="far fa-user"></i> Joueur 1</h3>
                <form action="" method="POST">
                    <input type="text" name="joueur1" id="joueur1" class="form-control text-center font-weight-bold text-white bg-primary" value="<?php echo $Joueur1; ?>" readonly>
                    <!-- on met un champ hidden "joueur2" pour envoyer le score du Joueur 2 depuis ce formulaire meme si on ne l'affiche pas -->
                    <input type="hidden" name="joueur2" id="joueur2" value="<?php echo $Joueur2; ?>">
                    <!-- on met un champ hidden "win1" pour que l'algorithme incrémente le score du Joueur 1 -->
                    <input type="hidden" name="win1" id="win1" value="yes">
                    <button type="submit" class="btn btn-block btn-outline-primary font-weight-bold">
                        <i class="fas fa-trophy"></i> +1
                    </button>
                </form>
            </div>
            <!-- Encadré qui affiche le score du Joueur 2 et avec formulaire qui demande à l'algorithme de d'incrémenter son score -->
            <div class="col-6 col-md-4 col-xl-2 alert alert-danger">
                <h3 class="text-danger font-weight-bold text-center"><i class="far fa-user"></i> Joueur 2</h3>
                <form action="" method="POST">
                    <input type="text" name="joueur2" id="joueur2" class="form-control text-center font-weight-bold text-white bg-danger" value="<?php echo $Joueur2; ?>" readonly>
                    <!-- on met un champ hidden "joueur1" pour envoyer le score du Joueur 1 depuis ce formulaire meme si on ne l'affiche pas -->
                    <input type="hidden" name="joueur1" id="joueur1" value="<?php echo $Joueur1; ?>">
                    <!-- on met un champ hidden "win2" pour que l'algorithme incrémente le score du Joueur 2 -->
                    <input type="hidden" name="win2" id="win2" value="yes">
                    <button type="submit" class="btn btn-block btn-outline-danger font-weight-bold">
                        <i class="fas fa-trophy"></i> +1
                    </button>
                </form>
            </div>
        </div>
        <!-- formulaire pour lancer une remise à zéro -->
        <div class="row">
            <form action="" method="POST" class="offset-md-2 offset-xl-4 col-8">
                <div class="form-group">
                    <!-- on met un champ hidden "zero" pour que l'algorithme remette les variables à zéro -->
                    <input type="hidden" name="zero" id="zero" value="obliviate">
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-undo"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>




    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>