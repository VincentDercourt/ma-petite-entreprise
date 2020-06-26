<?php

require_once ROOT . '/src/Request.php';
require_once ROOT . '/src/View.php';

/**
 * Classe abstraite Controller
 * Fournit des services communs aux classes Controller dérivées
 * @version 1.0
 * @author Baptiste Pesquet
 * @edit by Vincent DERCOURT
 */
abstract class Controller
{

    /** Requête entrante */
    protected Request $request;
    /** Action à réaliser */
    private string $action;
    protected string $webroot;

    /**
     * Définit la requête entrante
     *
     * @param Request $request Request entrante
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        $this->webroot = Configuration::get("webRoot", "/");
    }

    /**
     * Exécute l'action à réaliser.
     * Appelle la méthode portant le même nom que l'action sur l'objet Controller courant
     *
     * @param String $action
     * @throws Exception Si l'action n'existe pas dans la classe Controller courante
     */
    public function executeAction(string $action): void
    {
        define("ACTION", $action);
        if (method_exists($this, $action)) {
            $this->action = $action;
            $this->{$this->action}();
        } else {
            $classController = get_class($this);
            throw new Exception("Action '$action' non définie dans la classe $classController");
        }
    }

    /**
     * Méthode abstraite correspondant à l'action par défaut
     * Oblige les classes dérivées à implémenter cette action par défaut
     */
    abstract public function index();

    /**
     * Génère la vue associée au contrôleur courant
     *
     * @param array $dataView Données nécessaires pour la génération de la vue
     * @return void
     */
    protected function generateView(array $dataView = []): void
    {
        // Détermination du nom du fichier vue à partir du nom du contrôleur actuel
        $classController = get_class($this);
        $controller = str_replace("Controller", "", $classController);

        $view = $this->action;
        if (isset($dataView["view"])) {
            $view = $dataView["view"];
        }
        // Instanciation et génération de la vueF
        $view = new View($view, $controller);
        $view->generate($dataView);
    }

    /**
     * Effectue une redirection vers un contrôleur et une action spécifiques
     *
     * @param string $controller Contrôleur
     * @param string|null $action Action Action
     */
    protected function redirect(string $controller, $action = null)
    {
        $webRoot = Configuration::get("webRoot", "/");
        // Redirection vers l'URL racine_site/controller/action
        header("Location:" . $racineWeb . $controller . "/" . $action);
        exit;
    }

}
