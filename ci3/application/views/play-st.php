            <h2 class="text-center system font-weight-bold">
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
            <form action="" method="POST" class="" validate>
                <div class="form-group text-center">
                    <label for="essai">Vous proposez ?</label>
                    <br>
                    <input type="tel" name="essai" id="essai" pattern="<?php echo $ExReg; ?>" minlength="1" maxlength="3" class="lcars-form-label system" autocomplete="off" autofocus required>
                </div>
                <div class="form-group lcars-container lcars-radio-group">
                    <button type="submit" class="lcars system btn-block font-weight-bold lcars-left">
                        <i class="fas fa-hand-sparkles"></i> Essayer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="offset-1 col-10 offset-md-2 col-md-8 offset-lg-4 col-lg-4">
        <form action="" method="POST" class="" validate>
            <div class="form-group">
                <input type="hidden" name="again" id="again" value="letsgo" required>
                <button type="submit" class="lcars info lcars-left lcars-right" autofocus>
                    <i class="fas fa-dice"></i> Nouvelle Partie
                </button>
            </div>
        </form>
