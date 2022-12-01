<?php
namespace App\SIDAQuest\Controller;

use App\SIDAQuest\Config\Conf;
use App\SIDAQuest\Lib\MessageFlash;
use App\SIDAQuest\Lib\PreferenceController;

abstract class Controller
{
    public static abstract function readAll(): void;

    protected abstract function getNomVueError(): string;

    protected static function afficheVue(string $cheminVue, string $url, array $parametres = []): void
    {
        extract($parametres);
        require __DIR__ . "/../view/$cheminVue";
    }

    public static function error(string $error = ""): void
    {
        $ancienURL = $_SERVER['HTTP_REFERER'];
        MessageFlash::ajouter("danger", $error);
        self::redirect($ancienURL);
    }

    public static function redirect($url): void{
        header("Location: $url");
        exit();
    }
}


?>
