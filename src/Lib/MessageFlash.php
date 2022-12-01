<?php

namespace App\SIDAQuest\Lib;

use App\SIDAQuest\Model\HTTP\Session;

class MessageFlash
{
    // Les messages sont enregistrés en session associée à la clé suivante
    private static string $cleFlash = "_messagesFlash";

    // $type parmi "success", "info", "warning" ou "danger"
    public static function ajouter(string $type, string $message): void
    {
        Session::getInstance()->enregistrer($type . static::$cleFlash, $message);
    }

    public static function contientMessage(string $type): bool
    {
        return Session::getInstance()->contient($type . static::$cleFlash);
    }

    // Attention : la lecture doit détruire le message
    public static function lireMessages(string $type): array
    {
        $val = $type . static::$cleFlash;
        $array = [];
        $array[] = Session::getInstance()->lire($val);
        Session::getInstance()->supprimer($val);
        return $array;
    }

    public static function lireTousMessages() : array
    {
        $message = [];

        if(self::contientMessage("success")) {
            foreach (self::lireMessages("success") as $message) {
                $message[] = $message;
            }
        }

        if(self::contientMessage("info")) {
            foreach (self::lireMessages("info") as $message) {
                $message[] = $message;
            }
        }

        if(self::contientMessage("warning")) {
            foreach (self::lireMessages("warning") as $message) {
                $message[] = $message;
            }
        }

        if(self::contientMessage("danger")) {
            foreach (self::lireMessages("danger") as $message) {
                $message[] = $message;
            }
        }

        return $message;
    }


}