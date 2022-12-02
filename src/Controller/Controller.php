<?php
namespace App\SIDAQuest\Controller;

use App\SIDAQuest\Config\Conf;
use App\SIDAQuest\Lib\MessageFlash;
use App\SIDAQuest\Lib\PreferenceController;

class Controller {
    protected abstract function getNomVueError() : string;

    protected static function afficheVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres);
        require __DIR__ . "/../view/$cheminVue";
    }

    public static function error(string $error = "") : void {
        $ancienURL = $_SERVER['HTTP_REFERER'];
        MessageFlash::ajouter("danger", $error);
        self::redirect($ancienURL);
    }

    public static function redirect($url) : void {
        header("Location: $url");
        exit();
    }

    public static function accueil() : void {
        static::afficheVue('view.php', ["pagetitle" => "SIDAQuest - Accueil", "cheminVueBody" => "accueil.php"]);
    }
}
?>
