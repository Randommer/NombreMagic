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
            <button type="submit" class="btn btn-info" autofocus>
                <i class="fas fa-dice"></i> Nouvelle Partie
            </button>
        </div>
    </form>
</div>