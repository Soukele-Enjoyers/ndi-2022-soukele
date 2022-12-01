<?php

namespace App\SIDAQuest\Model\Repository;

use App\SIDAQuest\Model\DataObject\AbstractDataObject;
use PDO;
use PDOException;

abstract class AbstractRepository
{

    protected abstract function getNomTable() : string;

    protected abstract function construire(array $objetFormatTableau) : AbstractDataObject;

    protected abstract function getNomClePrimaire() : string;

    protected abstract function getNomsColonnes() : array;

    public function selectAll() : array {
        $tab = [];
        $sql = "SELECT * FROM {$this->getNomTable()};";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $pdoStatement->execute();
        foreach ($pdoStatement as $objectFormatTab) {
            $tab[] = $this->construire($objectFormatTab);
        }
        return $tab;
    }

    public function update(AbstractDataObject $object) : bool {
        $nomClePrimaire = $this->getNomClePrimaire();
        $sql = "UPDATE {$this->getNomTable()} SET $nomClePrimaire = :{$nomClePrimaire}Tag";
        foreach ($this->getNomsColonnes() as $colonne) $sql .= ", $colonne = :{$colonne}Tag ";
        $sql .= "WHERE $nomClePrimaire = :{$nomClePrimaire}Tag;";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
        $values = $object->formatTableau();
        try {
            $pdoStatement->execute($values);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function create(AbstractDataObject $object) : bool {
        $sql = "INSERT INTO {$this->getNomTable()} VALUES (:{$this->getNomClePrimaire()}Tag";
        foreach ($this->getNomsColonnes() as $colonne) $sql .= ", :{$colonne}Tag";
        $sql .= ");";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
        $values = $object->formatTableau();
        try {
            $pdoStatement->execute($values);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete(string $valeurClePrimaire) : bool {
        $clePrimaire = $this->getNomClePrimaire();
        $sql = "DELETE FROM {$this->getNomTable()} WHERE $clePrimaire = :{$clePrimaire}Tag;";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
        $values = ["{$clePrimaire}Tag" => $valeurClePrimaire];
        try {
            $pdoStatement->execute($values);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function select(string $valeurClePrimaire) : ?AbstractDataObject {
        $clePrimaire = $this->getNomClePrimaire();
        $sql = "SELECT * FROM {$this->getNomTable()} WHERE $clePrimaire = :{$clePrimaire}Tag;";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
        $values = ["{$clePrimaire}Tag" => $valeurClePrimaire];
        $pdoStatement->execute($values);
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $objet = $pdoStatement->fetch();
        return $objet ? $this->construire($objet) : null;
    }
}