<?php

namespace App\SIDAQuest\Lib;

class PasswordUtils
{
    // Exécutez genererChaineAleatoire() et stockez sa sortie dans le poivre
    private static string $poivre = "AIk7m8BSRH3X3hNTxsS3C6";

    public static function hacher(string $mdpClair): string
    {
        $mdpPoivre = hash_hmac("sha256", $mdpClair, static::$poivre);
        $mdpHache = password_hash($mdpPoivre, PASSWORD_DEFAULT);
        return $mdpHache;
    }

    public static function verifier(string $mdpClair, string $mdpHache): bool
    {
        $mdpPoivre = hash_hmac("sha256", $mdpClair, static::$poivre);
        return password_verify($mdpPoivre, $mdpHache);
    }

    public static function genererChaineAleatoire(int $nbCaracteres = 22): string
    {
    // 22 caractères par défaut pour avoir au moins 128 bits aléatoires
    // 1 caractère = 6 bits car 64=2^6 caractères en base_64
    // et 128 <= 22*6 = 132
        $octetsAleatoires = random_bytes(ceil($nbCaracteres * 6 / 8));
        return substr(base64_encode($octetsAleatoires), 0, $nbCaracteres);
    }



}