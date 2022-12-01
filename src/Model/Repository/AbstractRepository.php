<?php

namespace App\SIDAQuest\Model\Repository;

use App\SIDAQuest\Model\DataObject\AbstractDataObject;

abstract class AbstractRepository
{

    protected abstract function getNomTable(): string;

    protected abstract function construire(array $objetFormatTableau): AbstractDataObject;

    protected abstract function getNomClePrimaire(): string;

    protected abstract function getNomsColonnes(): array;

    public function selectAll(): array
    {
        $tab = [];
        $nom = $this->getNomTable();

        $sql = "SELECT * FROM $nom";

        $values = array(
        );

        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
        $pdoStatement->execute($values);

        foreach ($pdoStatement as $objectFormatTab) {
            $tab[] = $this->construire($objectFormatTab);
        }
        return $tab;
    }

    public function update(AbstractDataObject $object): void
    {

        $nomColonnes = $this->getNomsColonnes();
        $nom = $this->getNomTable();
        $nomClesPrimaire = $this->getNomClePrimaire();

        $sql = "UPDATE $nom SET $nomClesPrimaire=:clesPrimaireTag";

        foreach ($nomColonnes as $colonne) {
            $sql .= ", $colonne=:$colonne" . "Tag ";
        }

        $sql .= "WHERE $nomClesPrimaire=:clesPrimaireTag";

        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);

        $values = $object->formatTableau();

        $pdoStatement->execute($values);
    }

    public function save(AbstractDataObject $object): void
    {
        $nom = $this->getNomTable();
        $nomColonnes = $this->getNomsColonnes();

        $nomClesPrimaire = $this->getNomClePrimaire();

        $sql = "INSERT INTO $nom VALUES (:clesPrimaireTag";

        foreach ($nomColonnes as $colonne){
            $sql .= ", :$colonne" . "Tag";
        }

        $sql .= ");";

        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);

        $values = $object->formatTableau();

        $pdoStatement->execute($values);
    }

    public function delete(string $valeurClePrimaire): ?string
    {

        $nom = $this->getNomTable();
        $clesPrimaire = $this->getNomClePrimaire();

        $sql = "DELETE FROM $nom WHERE $clesPrimaire=:clesPrimaireTag";

        if (is_null(self::select($valeurClePrimaire))) return null;

        // Préparation de la requête
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);

        $values = array(
            "clesPrimaireTag" => $valeurClePrimaire,
            //nomdutag => valeur, ...
        );
        // On donne les valeurs et on exécute la requête
        $pdoStatement->execute($values);

        return "$nom de clé primaire : $valeurClePrimaire à bien été supprimée !";
    }

    public function select(string $valeurClePrimaire): ?AbstractDataObject
    {
        $nom = $this->getNomTable();
        $clesPrimaire = $this->getNomClePrimaire();
        $sql = "SELECT * from $nom WHERE $clesPrimaire=:clesPrimaireTag";
        // Préparation de la requête
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);

        $values = array(
            "clesPrimaireTag" => $valeurClePrimaire,
            //nomdutag => valeur, ...
        );
        // On donne les valeurs et on exécute la requête
        $pdoStatement->execute($values);

        // On récupère les résultats comme précédemment
        // Note: fetch() renvoie false si pas de voiture correspondante
        $objet = $pdoStatement->fetch();
        if (!$objet) return null;

        return $this->construire($objet);
    }
}