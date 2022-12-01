<?php

namespace App\SIDAQuest\Controller;

use App\SIDAQuest\Config\Conf;
use App\SIDAQuest\Lib\ConnexionUtilisateur;
use App\SIDAQuest\Lib\MessageFlash;
use App\SIDAQuest\Lib\MotDePasse;
use App\SIDAQuest\Model\Repository\UtilisateurRepository;
use App\SIDAQuest\Model\DataObject\Utilisateur;

class ControllerUtilisateur extends Controller
{

    public static function read():void
    {
        $utilisateur = (new UtilisateurRepository())->select($_GET['login']);
        if(is_null($utilisateur)){
            MessageFlash::ajouter("warning", "Il semblerait que cet utilisateur n'existe pas !");
        }else{
            self::afficheVue('view.php', Conf::getUrlBase(), ["utilisateur" => $utilisateur, "pagetitle" => "Informations du compte", "cheminVueBody" => "utilisateur/detail.php"]);
        }
    }


    public static function create(): void{
        self::afficheVue('view.php', Conf::getUrlBase(), ["pagetitle" => "Formulaire création compte", "cheminVueBody" => "utilisateur/inscription.php"]);
    }

    public static function created(): void
    {
        $url = "";// Conf::getUrlBase();
        $login = $_POST["login"];
        $loginURL = urlencode($login);

        if(strcmp($_POST['password'], $_POST['password2']) != 0){

            MessageFlash::ajouter("warning", "Mots de passe distincts");
            self::redirect("$url". "frontController.php?controller=utilisateur&action=create");

        }else if(!is_null((new UtilisateurRepository())->select($_POST['login']))){

            MessageFlash::ajouter("warning", "Login existant !");
            self::redirect("$url". "frontController.php?controller=utilisateur&action=create");

        }else {
            MessageFlash::ajouter("success", "L'utilisateur a été créé avec succés");
            $utilisateursForm = Utilisateur::construireDepuisFormulaire($_POST);
            (new UtilisateurRepository())->create($utilisateursForm);
            self::redirect("$url". "frontController.php?controller=utilisateur&action=read&login=$loginURL");
        }
    }


    protected function getNomVueError(): string
    {
        // TODO: Implement getNomVueError() method.
        return "utilisateur";
    }

    public static function connect(): void{
        self::afficheVue('view.php', Conf::getUrlBase(),["pagetitle" => "Formulaire de connexion", "cheminVueBody" => "utilisateur/connexion.php"]);
    }

    public static function connecter(): void{
        //MESSAGE FLASH

        $login = $_POST['login'];
        $utilisateurTemp = (new UtilisateurRepository)->select($login);
        //$mdpHache = $utilisateurTemp->getMdpHache();
        $urlBase = "";// Conf::getUrlBase();

        //MESSAGE FLASH
        if(!isset($login) || !isset($_POST['password'])){

            MessageFlash::ajouter("danger", "login ou mot de passe manquant !");
            self::redirect($urlBase . "frontController.php?controller=utilisateur&action=connect");

        } else if(is_null($utilisateurTemp)) {

            MessageFlash::ajouter("warning", "login incorrect");
            self::redirect($urlBase . "frontController.php?controller=utilisateur&action=connect");

        } else if(!MotDePasse::verifier($_POST['password'],  $utilisateurTemp->getMdpHache())){

                MessageFlash::ajouter("warning", "Mot de passe incorrect");
                self::redirect($urlBase . "frontController.php?controller=utilisateur&action=connect");

        }else {
            ConnexionUtilisateur::connecter($login);
            $loginURL = urlencode($login);
            MessageFlash::ajouter("success", "Vous vous êtes connecté avec succès !");
            $url = "frontController.php?controller=utilisateur&action=read&login=$loginURL";
            self::redirect($url);
        }
    }

    public static function deconnecter(){
        ConnexionUtilisateur::deconnecter();
        MessageFlash::ajouter("success", "Vous avez été déconnecté !");
        $url = ""; //Conf::getUrlBase();
        self::redirect($url . "frontController.php");
    }

    public static function update(): void
    {
        if(!isset($_POST['login'])) $login = $_GET["login"];
        else $login = $_POST['login'];
        $utilisateur = (new UtilisateurRepository())->select($login);
        self::afficheVue('view.php', Conf::getUrlBase(), ["utilisateur" => $utilisateur, "pagetitle" => "Formulaire changement profil ", "cheminVueBody" => "utilisateur/update.php"]);
    }

    public static function updated(): void
    {
        $login = $_POST['login'];
        $temp = (new UtilisateurRepository())->select($login);
        print_r($temp);
        $mdpHache = $temp->getMdpHache();
        $loginURL = urlencode($login);
        $url = ""; //Conf::getUrlBase();

        if (strcmp($_POST['password'], $_POST['password2']) != 0){

            MessageFlash::ajouter("warning", "Mots de passe distincts !");
            self::redirect($url . "frontController.php?action=update&controller=utilisateur&login=$loginURL");

        }else if (!MotDePasse::verifier($_POST['ancienPassword'], $mdpHache)){

            MessageFlash::ajouter("warning", "Ancien mot de passe erroné !");
            self::redirect($url . "frontController.php?action=update&controller=utilisateur&login=$loginURL");

        }else {

            $temp->setMdpHache($_POST['password']);
            (new UtilisateurRepository())->update($temp);
            //$utilisateurs = (new UtilisateurRepository())->selectAll();
            MessageFlash::ajouter("success", "L'utilisateur a bien été modifié !");
            self::redirect($url . "frontController.php");
        }
    }

    public static function delete(): void
    {
        $message = (new UtilisateurRepository())->delete($_POST['login']);
        if (is_null($message)) self::error("Le supression n'a pas fonctionnée");
        ControllerQuestion::readAll(1);
    }


    public static function readAll() : void {}
}