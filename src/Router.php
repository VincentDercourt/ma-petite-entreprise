<?php

require_once ROOT . '/src/Controller.php';
require_once ROOT . '/src/Request.php';
require_once ROOT . '/src/View.php';

/*
 * Classe de routage des requêtes entrantes.
 * Inspirée du framework PHP de Nathan Davison
 * (https://github.com/ndavison/Nathan-MVC)
 * @version 1.0
 * @author Baptiste Pesquet
 * @edit by Vincent DERCOURT
 */

class Router
{

    /**
     * Méthode principale appelée par le contrôleur frontal
     * Examine la requête et exécute l'action appropriée
     */
    public function routerRequest()
    {
        try {
            // Fusion des paramètres GET et POST de la requête
            // Permet de gérer uniformément ces deux types de requête HTTP
            $request = new Request(array_merge($_GET, $_POST));

            $controller = $this->createController($request);
            $action = $this->createAction($request);

            $controller->executeAction($action);
        } catch (Exception $e) {
            $this->manageError($e);
        }
    }

    /**
     * Instancie le contrôleur approprié en fonction de la requête reçue
     * @param Request $request Requête reçue
     * @return Object d'un contrôleur
     * @throws Exception Si la création du contrôleur échoue
     */
    private function createController(Request $request): object
    {
        // Grâce à la redirection, toutes les URL entrantes sont du type :
        // index.php?controller=XXX&action=YYY&id=ZZZ

        // Contrôleur par défaut
        $controller = Configuration::get("controllerDefault", "Home");
        if ($request->issetParameter('controller')) {
            $controller = $request->getParameter('controller');
            // Première lettre en majuscules
            $controller = ucfirst(strtolower($controller));
        }
        $controller = ucfirst($controller);
        // Création du nom du fichier du contrôleur
        // La convention de nommage des fichiers controllers est : app/controller/Controller<$controller>.php
        $controllerPath = Configuration::get(
            "controllerPath",
            "app/controller"
        );
        define("CONTROLLER", $controller);
        $classController = "Controller" . $controller;
        $fileController = ROOT . DS . $controllerPath . DS . $classController . ".php";
        if (file_exists($fileController)) {
            // Instanciation du contrôleur adapté à la requête
            require($fileController);
            $controller = new $classController();
            $controller->setRequest($request);
            return $controller;
        } else {
            throw new Exception("Fichier '$fileController' introuvable");
        }
    }

    /**
     * Détermine l'action à exécuter en fonction de la requête reçue
     * @param Request $request Requête reçue
     * @return string Action à exécuter
     */
    private function createAction(Request $request): string
    {
        // Action par défaut
        $action = Configuration::get("actionDefault", "index");
        if ($request->issetParameter('action')) {
            try {
                $action = $request->getParameter('action');
            } catch (Exception $e) {
                echo $e->getMessage();
                exit();
            }
        }
        return $action;
    }

    /**
     * Gère une erreur d'exécution (exception)
     * @param Exception $exception Exception qui s'est produite
     */
    private function manageError(Exception $exception)
    {
        $vue = new View('error');
        $vue->generate(array('msgError' => $exception->getMessage()));
    }
}
