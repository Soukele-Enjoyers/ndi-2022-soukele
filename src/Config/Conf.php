<?php

namespace App\SIDAQuest\Config;

class Conf
{
    static private array $databases = [
        'hostname' => '',
        'database' => '',
        'login' => '',
        'password' => '',
    ];

    static private int $dureeExpiration = 3600; //Les sessions expirent après 3600 secondes

    static private array $noms = [
        "Gabin" => "",
        "Hugo" => "http://localhost/ndi-2022-soukele/web/"
    ];

    static private string $quiSuisJe = "Hugo";

    public static function getUrlBase() : string {
        return static::$noms[static::$quiSuisJe];
    }

    static public function getDureeExpiration() : int {
        return static::$dureeExpiration;
    }

    static public function getLogin() : string {
        return static::$databases['login'];
    }

    static public function getHostname() : string {
        return static::$databases['hostname'];
    }

    static public function getDatabase() : string {
        return static::$databases['database'];
    }

    static public function getPassword() : string {
        return static::$databases['password'];
    }
}
