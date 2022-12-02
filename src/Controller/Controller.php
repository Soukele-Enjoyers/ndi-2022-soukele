<?php
namespace App\SIDAQuest\Controller;


use App\SIDAQuest\Lib\MessageFlash;

class Controller {
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

    public static function play() : void {
        static::afficheVue('view.php', ["pagetitle" => "SIDAQuest", "cheminVueBody" => "game.php"]);
    }
}
?>
