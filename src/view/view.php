<?php
use App\SIDAQuest\Lib\ConnexionUtilisateur;
use App\SIDAQuest\Lib\MessageFlash;
/* @var string $pagetitle */
/* @var string $cheminVueBody */
?>

<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <title><?php echo $pagetitle; ?></title>

    <link href="css/styles/bootstrap.css" rel="stylesheet" type="text/css">
</head>
<body class="bg-color d-flex flex-column h-100">
<header class="fw-bold h-25 d-flex align-items-end justify-content-center">
    <div class="alert alert-success d-flex px-5 position-relative opacity-0 mb-5 top-40\">$tab[0]</div>
    <nav class="navbar fixed-top navbar-expand-lg navbar-light p-md-3">
        <div class="container-fluid">
            <ul class="navbar-nav me-auto mb-2">
                <li class="nav-item"><a href="frontController.php" class="nav-link active navbar-brand" aria-current="page">SIDAQuest</a></li>
            </ul>

            <?php
            if (!ConnexionUtilisateur::estConnecte())
            {
                echo "<a href=\"frontController.php?controller=utilisateur&action=connect\" class=\"nav-link active\">Se connecter</a>";
                echo "<a href=\"frontController.php?controller=utilisateur&action=create\"  class=\"nav-link active mx-4\">S'inscrire</a>";
            }
            else
            {
                $login = ConnexionUtilisateur::getLoginUtilisateurConnecte();
                $loginURL = urlencode($login);

                echo "<a href=\"frontController.php?controller=utilisateur&action=read&login=$loginURL\"  class=\"nav-link active ms-4\"><img src=\"./img/user.png\" alt=\"informations\" title=\"enter\"></a>";
                echo "<a href=\"frontController.php?controller=utilisateur&action=deconnecter\" class=\"nav-link active mx-4\"><img src=\"./img/logout.png\" alt=\"logout\" title=\"out\"></a>";
            }
            ?>
        </div>
    </nav>

    <?php
    if(MessageFlash::contientMessage("warning"))
    {
        foreach (MessageFlash::lireMessages("warning") as $message) {
            echo "<div class=\"alert alert-warning d-flex px-5 position-absolute mb-5\">$message</div>";
        }
    }
    else if(MessageFlash::contientMessage("success"))
    {
        foreach (MessageFlash::lireMessages("success") as $message) {
            echo "<div class=\"alert alert-warning d-flex px-5 position-absolute mb-5\">$message</div>";
        }
    }
    else if(MessageFlash::contientMessage("info"))
    {
        foreach (MessageFlash::lireMessages("info") as $message) {
            echo "<div class=\"alert alert-warning d-flex px-5 position-absolute mb-5\">$message</div>";
        }
    }
    else if(MessageFlash::contientMessage("danger"))
    {
        foreach (MessageFlash::lireMessages("danger") as $message) {
            echo "<div class=\"alert alert-warning d-flex px-5 position-absolute mb-5\">$message</div>";
        }
    }
    ?>
</header>

<main class="d-flex flex-row w-100 justify-content-center">
        <?php require __DIR__ . "/$cheminVueBody"; ?>
</main>

<!--        <button type="button" id="light">Jour</button>-->
<!--        <script src="JS/switchClairSombre.js"></script>-->

<footer class="text-lg-start h-25 d-flex justify-content-center pt-5">
    <p class="text-center top-50">NDI SIDAQuest 2022</p>
</footer>
</body>
</html>
