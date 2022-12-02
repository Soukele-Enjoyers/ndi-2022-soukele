<?php

namespace App\SIDAQuest\Model\HTTP;
use App\SIDAQuest\Config\Conf;
use Exception;

class Session {
    private static ?Session $instance = null;

    /**
     * @throws Exception
     */
    private function __construct() {
        if (!session_start()) {
            throw new Exception("Session Error: Unable to start.");
        }
    }

    public static function getInstance() : Session {
        if (is_null(static::$instance)) {
            static::$instance = new Session();
            static::verifierDerniereActivite();
        }
        return static::$instance;
    }

    public function contient($name) : bool {
        return isset($_SESSION[$name]);
    }

    public function enregistrer(string $name, $value) : void {
        $_SESSION[$name] = $value;
    }

    public function lire(string $name) : mixed {
        return $_SESSION[$name];
    }

    public function supprimer(string $name) : void {
        unset($_SESSION[$name]);
    }

    public static function detruire() : void {
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
        Cookie::supprimer(session_name()); // deletes the session cookie
        static::$instance = null;
    }

    public static function verifierDerniereActivite() {
        if (isset($_SESSION['derniereActivite']) && time() - $_SESSION['derniereActivite'] > (Conf::getDureeExpiration())) {
            static::detruire();
        }
        $_SESSION['derniereActivite'] = time();
    }
}
