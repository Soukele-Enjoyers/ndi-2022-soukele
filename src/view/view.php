<?php
use App\SIDAQuest\Config\Conf;
use App\SIDAQuest\Lib\ConnexionUtilisateur;
use App\SIDAQuest\Lib\MessageFlash;

if (!isset($url))
{
    $url = Conf::getUrlBase();
}
?>

<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <title><?php echo $pagetitle; ?></title>
    <!-- <link href="css/styles/style.css" rel="stylesheet" type="text/css"> -->
    <link href="css/styles/bootstrap.css" rel="stylesheet" type="text/css">
</head>
<body class="bg-image d-flex flex-column h-100">
<header class="fw-bold h-25 d-flex align-items-end justify-content-center">
    <div class="alert alert-success d-flex px-5 position-relative opacity-0 mb-5 top-40\">$tab[0]</div>
    <nav class="navbar fixed-top navbar-expand-lg navbar-light p-md-3">
        <div class="container-fluid">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a href="<?php echo $url; ?>frontController.php" class="nav-link active navbar-brand" aria-current="page">AgoraScript</a></li>
                <li class="nav-item"><a href="<?php echo $url; ?>frontController.php?controller=question&action=readAll&etat=0" class="nav-link active">Questions</a></li>
                <li class="nav-item"><a href="<?php echo $url; ?>frontController.php?controller=question&action=readAll&etat=3" class="nav-link active">Votes</a></li>
                <li class="nav-item"><a href="<?php echo $url; ?>frontController.php?controller=question&action=readAll&etat=4" class="nav-link active">Résultats</a></li>
            </ul>

            <?php
            if (!ConnexionUtilisateur::estConnecte())
            {
                echo "<a href=\"$url" ."frontController.php?controller=utilisateur&action=connect\" class=\"nav-link active\">Se connecter</a>";
                echo "<a href=\"$url". "frontController.php?controller=utilisateur&action=create\"  class=\"nav-link active mx-4\">S'inscrire</a>";
            }
            else
            {
                $login = ConnexionUtilisateur::getLoginUtilisateurConnecte();
                $loginURL = urlencode($login);

                echo "<a href=\"$url" . "frontController.php?action=formulairePreference\" class='nav-link active ms-4'><img src=\"img/heart.png\" alt=\"heart\" title=\"coeur\"></a>";
                echo "<a href=\"$url" ."frontController.php?controller=utilisateur&action=read&login=$loginURL\"  class=\"nav-link active ms-4\"><img src=\"./img/user.png\" alt=\"informations\" title=\"enter\"></a>";
                echo "<a href=\"$url" ."frontController.php?controller=utilisateur&action=deconnecter\" class=\"nav-link active mx-4\"><img src=\"./img/logout.png\" alt=\"logout\" title=\"out\"></a>";
            }
            ?>
        </div>
    </nav>

    <?php
    if(MessageFlash::contientMessage("warning"))
    {
        $tab = MessageFlash::lireMessages("warning");
        echo "<div class=\"alert alert-warning d-flex px-5 position-absolute mb-5\">$tab[0]</div>";
    }
    else if(MessageFlash::contientMessage("success"))
    {
        $tab = MessageFlash::lireMessages("success");
        echo "<div class=\"alert alert-success d-flex px-5 position-absolute mb-5\">$tab[0]</div>";

    }
    else if(MessageFlash::contientMessage("info"))
    {
        $tab = MessageFlash::lireMessages("info");
        echo "<div class=\"alert alert-info d-flex px-5 position-absolute mb-5\">$tab[0]</div>";

    }
    else if(MessageFlash::contientMessage("danger"))
    {
        $tab = MessageFlash::lireMessages("danger");
        echo "<div class=\"alert alert-danger d-flex px-5 position-absolute mb-5\">$tab[0]</div>";
    }
    ?>
</header>

<main class="d-flex mx-10 flex-column">
    <?php require __DIR__ . "/$cheminVueBody"; ?>
</main>

<!--        <button type="button" id="light">Jour</button>-->
<!--        <script src="JS/switchClairSombre.js"></script>-->

<footer class="text-lg-start h-25 d-flex justify-content-center pt-5">
    <p class="text-center top-50">© AgoraScript 2022</p>
</footer>
</body>
</html>
