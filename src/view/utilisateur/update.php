<!DOCTYPE html>
<?php
/* @var App\SIDAQuest\Model\DataObject\Utilisateur $utilisateur */
    $loginHTML = htmlspecialchars($utilisateur->getLogin());
?>
<div class="bg-color2 d-flex flex-column p-5 rounded">
    <form method="post" action="frontController.php" ...>
        <fieldset class="bg-color2 d-flex flex-column p-5 rounded">
            <div class="mb-3">
                <div class="mb-3">
                    <label for="login_id" class="form-label">Login</label>
                    <input readonly type="text" value="<?= $loginHTML ?>" name="login" id="login_id" class="form-control" required/>
                </div>
                <div class="mb-3">
                    <label for="AncienPassword_id" class=form-label>Ancien mot de passe</label>
                    <input type="password"  name="ancienPassword" id="AncienPassword_id" class="form-control" required/>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="password_id">Nouveau mot de passe&#42;</label>
                <input class="form-control" type="password" name="password" id="password_id" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password2_id">Vérification du mot de passe&#42;</label>
                <input class=form-control type="password" name="password2" id="password2_id"  required>
            </div>
            <div class="mb-3">
                <input type="hidden" name="action" value="updated">
                <input type="hidden" name="controller" value="utilisateur">
            </div>

            <div class="d-flex justify-content-center pt-3">
                <input class="btn btn-lg btn-primary" type="submit" value="Envoyer"/>
            </div>
        </fieldset>
    </form>
</div>

