    <h2 class="text-success confirm font-weight-bold text-center"><i class="fas fa-trophy"></i> BRAVO <i class="fas fa-trophy"></i></h2>
    <p class="confirm">C'est gagné !!<br>
    <?php echo $TableauVariables["MagiqueN"]; ?> était bien le nombre magique.<br>
    Vous avez trouvé en <?php echo $TableauVariables["Tentatives"]; ?> tentatives.</p>
<form action="" method="POST" class="" validate>
    <div class="form-group lcars-container lcars-radio-group">
        <input type="hidden" name="again" id="again" value="letsgo" required>
        <button type="submit" class="lcars info lcars-left btn-block" autofocus>
            <i class="fas fa-dice"></i> Nouvelle Partie
        </button>
    </div>
</form>