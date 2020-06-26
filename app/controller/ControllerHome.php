<?php

require_once ROOT . '/src/Controller.php';
require_once ROOT . '/app/model/Employees.php';

/**
 * Contrôleur des actions liées aux billets
 *
 * @author Baptiste Pesquet
 * @edit by Vincent DERCOURT
 */
class ControllerHome extends Controller
{

    private Employees $employeesModel;

    public function __construct()
    {
        $this->employeesModel = new Employees();
    }

    // Affiche la liste de tous les billets du blog
    public function index()
    {
        $this->generateView(
            [
                "view" => "home",
                "employees" => $this->employeesModel->getEmployees()
            ]
        );
    }

}

