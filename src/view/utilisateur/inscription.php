<!DOCTYPE html>
<form method="post" action="frontController.php" ...>
    <fieldset class="">
        <div class="">
            <label for="login_id" class="">Login</label>
            <input type="text" placeholder="VirusSlayer891" name="login" id="login_id" class=""/>
        </div>
        <div class="">
            <label class="" for="password_id">Mot de passe&#42;</label>
            <input class="" type="password"  name="password" id="password_id" required>
        </div>
        <div class="">
            <label class="" for="password2_id">Vérification du mot de passe&#42;</label>
            <input class="" type="password" name="password2" id="password2_id" required>
        </div>

        <input type="hidden" name="action" value="created">
        <input type="hidden" name="controller" value="utilisateur">
        <div class="">
            <input class="" type="submit" value="Envoyer"/>
        </div>
    </fieldset>
</form>


