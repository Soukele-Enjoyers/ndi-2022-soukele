<?php

namespace App\SIDAQuest\Lib;

use App\SIDAQuest\Model\HTTP\Session;

class ConnexionUtilisateur
{
// L'utilisateur connecté sera enregistré en session associé à la clé suivante
    private static string $cleConnexion = "_utilisateurConnecte";

    public static function connecter(string $loginUtilisateur): void
    {
        $session = Session::getInstance();
        $session->enregistrer(static::$cleConnexion, $loginUtilisateur);
    }

    public static function estConnecte(): bool
    {
        $session = Session::getInstance();
        return $session->contient(static::$cleConnexion);
    }

    public static function deconnecter(): void
    {
        $session = Session::getInstance();
        $session->supprimer(static::$cleConnexion);
    }

    public static function getLoginUtilisateurConnecte(): ?string
    {
        $session = Session::getInstance();
        if (!self::estConnecte()) return null;
        return $session->lire(static::$cleConnexion);
    }

    public static function estUtilisateur($login):bool{
        return strcmp(self::getLoginUtilisateurConnecte(), $login) == 0 && self::estConnecte();
    }



}