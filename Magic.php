<?php
    session_start();
    $TableauVariables = array("MagiqueN" => random_int(1, 100), "Min" => 0, "Max" => 101, "Tentatives" => 0);
    if (isset($_SESSION["MagicTab"]))
    {
        $TableauVariables = $_SESSION["MagicTab"];
    }
    $gagne = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (!empty($_POST["again"]))
        {
            $TableauVariables = array("MagiqueN" => random_int(1, 100), "Min" => 0, "Max" => 101, "Tentatives" => 0);
        }
        else
        {
            $TableauVariables["Tentatives"]++;
            if ($_POST["essai"] == $TableauVariables["MagiqueN"])
            {
                //Winning
                $gagne = true;
            }
            else
            {
                if ($_POST["essai"] > $TableauVariables["MagiqueN"])
                {
                    $TableauVariables["Max"] = $_POST["essai"];
                    $audessus = true;
                }
                else
                {
                    $TableauVariables["Min"] = $_POST["essai"];
                    $audessus = false;
                }
            }
        }
    }
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
        <div class="row">
            <h1 class="col-12 offset-lg-3 col-lg-6 text-center font-weight-bold">Le Nombre Magique</h1>
        </div>
        <?php
            if ($gagne)
            {
        ?>
            <div class="row">
                <div class="offset-1 col-10 offset-md-2 col-md-8 offset-lg-4 col-lg-4 alert alert-success">
                    <h2 class="text-success font-weight-bold text-center"><i class="fas fa-trophy"></i> BRAVO <i class="fas fa-trophy"></i></h2>
                    <p>C'est gagné !!<br></p>
                    <p><?php echo $TableauVariables["MagiqueN"]; ?> était bien le nombre magique.<br></p>
                    <p>Vous avez trouvé en <?php echo $TableauVariables["Tentatives"]; ?> tentatives.</p>
                </div>
            </div>
            <div class="row">
                <form action="" method="POST" class="offset-1 col-10 offset-md-2 col-md-8 offset-lg-4 col-lg-4" validate>
                    <div class="form-group">
                        <input type="hidden" name="again" id="again" value="letsgo" required>
                        <button type="submit" class="btn btn-info btn-block" autofocus>
                            <i class="fas fa-dice"></i> Nouvelle Partie
                        </button>
                    </div>
                </form>
            </div>
        <?php 
            $_SESSION = array();
            if (ini_get("session.use_cookies")) 
            {
                setcookie(session_name(), '', time()-42);
            }
            session_destroy();
        }else{ 
            $ExReg = "(";
            for ($i = $TableauVariables["Min"] + 1; $i <= $TableauVariables["Max"] - 1; $i++)
            {
                $ExReg = $ExReg.$i."|";
            }
            $ExReg = $ExReg."code)";
            ?>
            <div class="row">
                <div class="offset-2 col-8 offset-md-3 col-md-6 offset-lg-4 col-lg-4 alert alert-warning">
                    <h2 class="text-center font-weight-bold">
                        <?php if ($TableauVariables["Min"] == 0) { ?>
                        1
                        <i class="fas fa-less-than-equal"></i>
                        <?php } else {
                        echo $TableauVariables["Min"]; ?>
                        <i class="fas fa-less-than"></i>
                        <?php } ?>
                        <i class="fas fa-question"></i>
                        <?php if ($TableauVariables["Max"] == 101) { ?>
                        <i class="fas fa-less-than-equal"></i>
                        100
                        <?php } else { ?>
                        <i class="fas fa-less-than"></i>
                        <?php echo $TableauVariables["Max"];
                        } ?>
                    </h2>
                </div>
            </div>
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
            <div class="row">
                <form action="" method="POST" class="offset-1 col-10 offset-md-2 col-md-8 offset-lg-4 col-lg-4" validate>
                    <div class="form-group">
                        <input type="hidden" name="again" id="again" value="letsgo" required>
                        <button type="submit" class="btn btn-info" autofocus>
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