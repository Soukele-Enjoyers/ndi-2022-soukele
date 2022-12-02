<?php

namespace App\SIDAQuest\Controller;

use App\SIDAQuest\Config\Conf;
use App\SIDAQuest\Lib\ConnexionUtilisateur;
use App\SIDAQuest\Lib\MessageFlash;
use App\SIDAQuest\Lib\PasswordUtils;
use App\SIDAQuest\Model\Repository\UtilisateurRepository;
use App\SIDAQuest\Model\DataObject\Utilisateur;

class ControllerUtilisateur extends Controller {

    public static function read() : void {
        $utilisateur = (new UtilisateurRepository())->select($_GET['login']);
        if(is_null($utilisateur)){
            MessageFlash::ajouter("warning", "Ce joueur n'existe pas.");
        }else{
            static::afficheVue('view.php', ["utilisateur" => $utilisateur, "pagetitle" => "Informations du compte", "cheminVueBody" => "utilisateur/detail.php"]);
        }
    }


    public static function create() : void {
        static::afficheVue('view.php', ["pagetitle" => "Inscription", "cheminVueBody" => "utilisateur/inscription.php"]);
    }

    public static function created() : void {
        $url = Conf::getUrlBase();
        if(strcmp($_POST['password'], $_POST['password2']) != 0) {
            MessageFlash::ajouter("warning", "Les mots de passe ne correspondent pas.");
            static::redirect($url . "frontController.php?controller=utilisateur&action=create");
        } else if (!is_null((new UtilisateurRepository())->select($_POST["login"]))) {
            MessageFlash::ajouter("warning", "L'identifiant est déjà utilisé.");
            static::redirect($url . "frontController.php?controller=utilisateur&action=create");
        } else {
            MessageFlash::ajouter("success", "Vous avez été enregistré avec succès !");
            $loginURL = urlencode($_POST["login"]);
            $utilisateurForm = Utilisateur::construireDepuisFormulaire($_POST);
            (new UtilisateurRepository())->create($utilisateurForm);
            static::redirect($url . "frontController.php?controller=utilisateur&action=read&login=$loginURL");
        }
    }

    protected function getNomVueError() : string {
        return "utilisateur";
    }

    public static function connect() : void {
        static::afficheVue('view.php', ["pagetitle" => "Connexion", "cheminVueBody" => "utilisateur/connexion.php"]);
    }

    public static function connected() : void {
        $login = $_POST["login"];
        $password = $_POST["password"];
        $utilisateurTemp = (new UtilisateurRepository)->select($login);
        $url = Conf::getUrlBase();
        if(!isset($login) || !isset($password)) {
            MessageFlash::ajouter("danger", "Identifiant ou mot de passe non renseigné.");
            static::redirect($url . "frontController.php?controller=utilisateur&action=connect");
        } else if (is_null($utilisateurTemp)) {
            MessageFlash::ajouter("warning", "Identifiant incorrect");
            static::redirect($url . "frontController.php?controller=utilisateur&action=connect");
        } else if (!PasswordUtils::verifier($_POST['password'],  $utilisateurTemp->getMdpHache())) {
                MessageFlash::ajouter("warning", "Mot de passe incorrect");
                static::redirect($url . "frontController.php?controller=utilisateur&action=connect");
        } else {
            ConnexionUtilisateur::connecter($login);
            $loginURL = urlencode($login);
            MessageFlash::ajouter("success", "Vous êtes connecté !");
            static::redirect($url . "frontController.php?controller=utilisateur&action=read&login=$loginURL");
        }
    }

    public static function disconnect() : void {
        ConnexionUtilisateur::deconnecter();
        MessageFlash::ajouter("success", "Déconnexion réalisée avec succès !");
        $url = Conf::getUrlBase();
        static::redirect($url . "frontController.php");
    }

    public static function update() : void {
        if(!isset($_POST['login'])) $login = $_GET["login"];
        else $login = $_POST['login'];
        $utilisateur = (new UtilisateurRepository())->select($login);
        self::afficheVue('view.php', ["utilisateur" => $utilisateur, "pagetitle" => "Mise à jour du profil", "cheminVueBody" => "utilisateur/update.php"]);
    }

    public static function updated() : void {
        $login = $_POST['login'];
        $temp = (new UtilisateurRepository())->select($login);
        $mdpHache = $temp->getMdpHache();
        $loginURL = urlencode($login);
        $url = Conf::getUrlBase();
        if (strcmp($_POST['password'], $_POST['password2']) != 0){
            MessageFlash::ajouter("warning", "Les mots de passe de correspondent pas.");
            static::redirect($url . "frontController.php?action=update&controller=utilisateur&login=$loginURL");
        } else if (!PasswordUtils::verifier($_POST['ancienPassword'], $mdpHache)) {
            MessageFlash::ajouter("warning", "Ancien mot de passe erroné.");
            static::redirect($url . "frontController.php?action=update&controller=utilisateur&login=$loginURL");
        } else {
            $temp->setMdpHache($_POST['password']);
            (new UtilisateurRepository())->update($temp);
            MessageFlash::ajouter("success", "Votre mot de passe a bien été modifié !");
            static::redirect($url . "frontController.php");
        }
    }

    public static function delete() : void {
        if (!(new UtilisateurRepository())->delete($_POST['login'])) static::error("Une erreur est survenue lors de la suppression.");
        else {
            MessageFlash::ajouter("success", "L'utilisateur a été supprimé avec succès !");
            static::redirect(Conf::getUrlBase() . "frontController.php");
        }
    }


    public static function readAll() : void {
        if (ConnexionUtilisateur::estConnecte() && Session::getInstance()->lire("isAdmin")) {
            $utilisateurs = (new UtilisateurRepository())->selectAll();
            static::afficheVue("view.php", ["pagetitle" => "Liste des joueurs", "cheminVueBody" => "utilisateurs/list.php", "utilisateurs" => $utilisateurs]);
        }
    }
}