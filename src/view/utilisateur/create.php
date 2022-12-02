<!DOCTYPE html>
<div class="bg-color2 d-flex flex-column p-5 rounded">
    <form method="post" action="frontController.php" ...>
        <fieldset class="bg-color2 d-flex flex-column p-5 rounded">
            <div class="mb-3">
                <label for="login_id" class="form-label">Login</label>
                <input type="text" placeholder="VirusSlayer891" name="login" id="login_id" class="form-control"/>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password_id">Mot de passe&#42;</label>
                <input class="form-control" type="password" name="password" id="password_id" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password2_id">Vérification du mot de passe&#42;</label>
                <input class="form-control" type="password" name="password2" id="password2_id" required>
            </div>

            <input type="hidden" name="action" value="created">
            <input type="hidden" name="controller" value="utilisateur">
            <div class="d-flex justify-content-center pt-3">
                <input class="btn btn-lg btn-primary" type="submit" value="Envoyer"/>
            </div>
        </fieldset>
    </form>
</div>

