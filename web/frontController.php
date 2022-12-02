<?php

require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

use App\SIDAQuest\Controller\Controller;

$loader = new App\SIDAQuest\Lib\Psr4AutoloaderClass();
$loader->addNamespace('App\SIDAQuest', __DIR__ . '/../src');
$loader->register();

$action = $_REQUEST['action'] ?? "accueil";
$controller = $_REQUEST['controller'] ?? "";

$controllerName = ucfirst($controller);

$controllerClassName = "App\SIDAQuest\Controller\Controller$controllerName";

if (class_exists($controllerClassName)){
    $tabMethode = get_class_methods($controllerClassName);
    if(in_array($action, $tabMethode)) $controllerClassName::$action();
    else {
        $class = new $controllerClassName;
        $class->error(); // Appel de la méthode statique $action de ControllerVoiture
    }

}

?>
