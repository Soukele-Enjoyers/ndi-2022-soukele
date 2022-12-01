<!DOCTYPE html>
<?php
    $loginHTML = htmlspecialchars($utilisateur->getLogin());
    $loginURL = rawurlencode($utilisateur->getLogin());
?>
<div class="">
    <p>
        Login : <?= $loginHTML ?>
    </p>
<?php
echo "<div class=\"\">";

echo '<form method="post" action="frontController.php" class= ...>
          <input type="hidden" name="action" value="update">
          <input type="hidden" name="controller" value="utilisateur">
          <input type="hidden" name="login"'. "value=\"$loginHTML\"> 
          <input class=\"\" type=\"submit\" value=\"Modifier Profil\"/> </form>";

echo '<form method="post" action="frontController.php" ...>
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="controller" value="utilisateur">
          <input type="hidden" name="login"'. "value=\"$loginHTML\"> 
          <input class=\"\" type=\"submit\" value=\"Supprimer Profil\"/> </form>";

echo "</div>";
echo "</div>";



