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