<?php

namespace App\SIDAQuest\Model\Repository;

use App\SIDAQuest\Model\DataObject\AbstractDataObject;
use App\SIDAQuest\Model\DataObject\Utilisateur;

class UtilisateurRepository extends AbstractRepository
{

    public function getNomTable() : string { return "ndi_users"; }


    public function construire(array $utilisateurTableau) : AbstractDataObject { return new Utilisateur($utilisateurTableau["login"], $utilisateurTableau["password"]); }

    public function getNomClePrimaire() : string { return "login"; }

    public function getNomsColonnes() : array { return ["password"]; }


    public function existe(string $login, string $password) : bool {
        $sql = "SELECT login FROM ndi_users WHERE login = loginTag AND password = :passwordTag;";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
        $values = ["loginTag" => $login, "passwordTag" => $password];
        $pdoStatement->execute($values);
        $utilisateur = $pdoStatement->fetch();
        return (bool) $utilisateur;
    }
}