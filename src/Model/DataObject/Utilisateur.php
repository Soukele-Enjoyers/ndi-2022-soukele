<?php

namespace App\SIDAQuest\Model\DataObject;

use App\SIDAQuest\Lib\MotDePasse;

class Utilisateur extends AbstractDataObject {

    private string $login;
    private string $mdpHache;

    public function __construct(string $login, string $mdp) {
        $this->login = $login;
        $this->mdpHache = $mdp;
    }


    public function formatTableau() : array { return ["passwordTag" => $this->mdpHache];
    }

    /**
     * @return string
     */
    public function getMdpHache() : string { return $this->mdpHache; }

    /**
     * @param string $mdpHache
     */
    public function setMdpHache(string $mdpClair) : void { $this->mdpHache = MotDePasse::hacher($mdpClair); }

    /**
     * @return string
     */
    public function getLogin() : string {return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login) : void { $this->login = $login; }

    public static function construireDepuisFormulaire(array $tableauFormulaire) : Utilisateur {
        $mdpHache = MotDePasse::hacher($tableauFormulaire['mdp']);
        return new Utilisateur($tableauFormulaire['login'], $mdpHache);
    }
}