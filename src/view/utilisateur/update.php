<!DOCTYPE html>
<?php
/* @var App\SIDAQuest\Model\DataObject\Utilisateur $utilisateur */
    $loginHTML = htmlspecialchars($utilisateur->getLogin());
?>
<form method="post" action="frontController.php" ...>
    <fieldset class="">
        <div class="">
            <div class="">
                <label for="login_id" class="">Login</label>
                <input readonly type="text" value="<?= $loginHTML ?>" name="login" id="login_id" class="" required/>
            </div>
            <div class="">
                <label for="AncienPassword_id" class="">Ancien mot de passe</label>
                <input type="password"  name="ancienPassword" id="AncienPassword_id" class="" required/>
            </div>
        </div>

        <div class="">
            <label class="" for="password_id">Nouveau mot de passe&#42;</label>
            <input class="" type="password" name="password" id="password_id" required>
        </div>
        <div class="">
            <label class="" for="password2_id">Vérification du mot de passe&#42;</label>
            <input class="" type="password" name="password2" id="password2_id"  required>
        </div>
        <div class="">
            <input type="hidden" name="action" value="updated">
            <input type="hidden" name="controller" value="utilisateur">
        </div>

        <div class="">
            <input class="" type="submit" value="Envoyer"/>
        </div>
    </fieldset>
</form>
