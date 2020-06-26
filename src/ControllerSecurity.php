<?php
require_once ROOT . '/src/Controller.php';

/**
 * Classe parente des contrôleurs soumis à authentification
 *
 * @author Baptiste Pesquet
 */
abstract class ControllerSecurity extends Controller
{
    public function executeAction($action): void
    {
        // Vérifie si les informations utilisateur sont présents dans la session
        // Si oui, l'utilisateur s'est déjà authentifié : l'exécution de l'action
        // continue normalement
        // Si non, l'utilisateur est renvoyé vers le contrôleur de connexion
        if ($this->request->getSession()->issetAttribut("auth")) {
            parent::executeAction($action);
        } else {
            $this->redirect("login");
        }
    }
}
