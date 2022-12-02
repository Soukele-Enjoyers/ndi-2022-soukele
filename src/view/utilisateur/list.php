<?php
/* @var App\SIDAQuest\Model\DataObject\Utilisateur[] $utilisateurs */

foreach ($utilisateurs as $utilisateur) {
    $loginHTML = htmlspecialchars($utilisateur->getLogin());
    echo "<div>Utilisateur $loginHTML <form method='post' action='frontController.php'> <input type='hidden' name='controller' value='utilisateur'><input type='hidden' name='action' value='delete'><input type='hidden' name='login' value='$loginHTML'><input type='submit' value='Supprimer'/></form></div>";
}
