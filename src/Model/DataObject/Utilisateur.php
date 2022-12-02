<?php

namespace App\SIDAQuest\Model\DataObject;

use App\SIDAQuest\Lib\PasswordUtils;

class Utilisateur extends AbstractDataObject {

    private string $login;
    private string $mdpHache;
    private bool $isAdmin; // Database stored: 1 -> TRUE | 0 -> FALSE

    public function __construct(string $login, string $mdp, bool $isAdmin) {
        $this->login = $login;
        $this->mdpHache = $mdp;
        $this->isAdmin = $isAdmin;
    }

    public function formatTableau() : array { return ["loginTag" => $this->login, "passwordTag" => $this->mdpHache, "isAdminTag" => $this->isAdmin ? 1 : 0]; }

    public static function construireDepuisFormulaire(array $tableauFormulaire) : Utilisateur {
        $mdpHache = PasswordUtils::hacher($tableauFormulaire['password']);
        return new static($tableauFormulaire['login'], $mdpHache, false);
    }

    /**
     * @return string
     */
    public function getMdpHache() : string { return $this->mdpHache; }

    /**
     * @param string $mdpHache
     */
    public function setMdpHache(string $mdpClair) : void { $this->mdpHache = PasswordUtils::hacher($mdpClair); }

    /**
     * @return string
     */
    public function getLogin() : string {return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login) : void { $this->login = $login; }

    /**
     * @return bool
     */
    public function isAdmin() : bool { return $this->isAdmin; }

    /**
     * @param bool $isAdmin
     */
    public function setIsAdmin(bool $isAdmin) : void { $this->isAdmin = $isAdmin; }
}