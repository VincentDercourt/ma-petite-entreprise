<?php
require_once ROOT . '/src/ControllerSecurity.php';
require_once ROOT . '/app/model/Roles.php';
require_once ROOT . '/app/model/Places.php';
require_once ROOT . '/app/model/Employees.php';

/**
 * Contrôleur des actions d'administration
 *
 * @author Baptiste Pesquet
 * @edited by Vincent DERCOURT
 */
class ControllerAdmin extends ControllerSecurity
{

    private Roles $role;
    private Places $place;
    private Employees $employee;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->role = new Roles();
        $this->place = new Places();
        $this->employee = new Employees();
    }

    public function index()
    {
        $this->generateView(
            [
                'view' => "admin",
                'employees' => $this->employee->getEmployees(),
                'places' => $this->place->getPlaces(),
                'roles' => $this->role->getRoles(),
            ]
        );
    }
}
