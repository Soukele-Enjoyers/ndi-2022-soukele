<?php

namespace App\SIDAQuest\Config;

class Conf
{
    static private array $databases = array(
        'hostname' => 'webinfo.iutmontp.univ-montp2.fr',
        'database' => 'brizayg',
        'login' => 'brizayg',
        'password' => 'tLMuCBMUHq58',
        'dureeExpiration' => 3600 //Les sessions expirent après 3600 secondes
    );

    static private array $noms = array(
        "Gabin" => "",
        "Hugo" => "http://localhost/SAE/web/"
    );

    static private string $quiSuisJe = "Hugo";

    public static function getUrlBase () : string
    {
        return static::$noms[static::$quiSuisJe];
    }

    static public function getDureeExpiration():int{
        return static::$databases['dureeExpiration'];
    }

    // static string $url = static::$noms["Vincent"];


    static public function getLogin(): string
    {
        return static::$databases['login'];
    }

    static public function getHostname(): string
    {
        return static::$databases['hostname'];
    }

    static public function getDatabase(): string
    {
        return static::$databases['database'];
    }

    static public function getPassword(): string
    {
        return static::$databases['password'];
    }
}