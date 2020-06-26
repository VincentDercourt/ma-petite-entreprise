<?php
require_once ROOT . '/src/ControllerSecurity.php';
require_once ROOT . '/app/model/Roles.php';
require_once ROOT . '/app/model/Places.php';
require_once ROOT . '/app/model/Employees.php';


class ControllerEmployees extends ControllerSecurity
{
    private Employees $employeesModel;
    private Roles $rolesModel;
    private Places $placesModel;

    public function __construct()
    {
        $this->employeesModel = new Employees();
        $this->rolesModel = new Roles();
        $this->placesModel = new Places();
    }

    public function index()
    {
    }

    public function add()
    {
        $firstName = (string)$this->request->getParameter("firstName");
        $lastName = (string)$this->request->getParameter("lastName");
        $roleId = (int)$this->request->getParameter("roleId");
        $placeId = (int)$this->request->getParameter("placeId");

        if (!preg_match("/[A-z0-9\-]{1,50}/", $firstName)) {
            throw new Exception("Impossible d'éditer l'employé, prénom incorrect");
        }
        if (!preg_match("/[A-z0-9\-]{1,50}/", $lastName)) {
            throw new Exception("Impossible d'éditer l'employé, nom de famille incorrect");
        }
        if ($roleId < 0 && !$this->rolesModel->getRole($roleId)) {
            throw new Exception("Impossible d'éditer l'employé, role incorrect");
        }
        if ($placeId < 0 && !$this->placesModel->getPlace($placeId)) {
            throw new Exception("Impossible d'éditer l'employé, Emplacement incorrect");
        }

        $this->employeesModel->addEmployee($firstName, $lastName, $roleId, $placeId);
        $this->redirect($this->webroot . "Admin");
    }

    public function editForm()
    {
        $id = (int)$this->request->getParameter("id");
        if (!($employee = $this->employeesModel->getEmployee($id))) {
            throw new Exception("L'employé {$id} n'existe pas");
        }

        $this->generateView(
            [
                "view" => "editEmployee",
                "employee" => $employee,
                "places" => $this->placesModel->getPlaces(),
                "roles" => $this->rolesModel->getRoles()
            ]
        );

    }

    public function edit()
    {
        $id = (int)$this->request->getParameter("id");
        $firstName = (string)$this->request->getParameter("firstName");
        $lastName = (string)$this->request->getParameter("lastName");
        $roleId = (int)$this->request->getParameter("roleId");
        $placeId = (int)$this->request->getParameter("placeId");

        if ($id < 0) {
            throw new Exception("Impossible d'éditer l'employé, identifiant incorrect");
        }
        if (!preg_match("/[A-z0-9\-]{1,50}/", $firstName)) {
            throw new Exception("Impossible d'éditer l'employé, prénom incorrect");
        }
        if (!preg_match("/[A-z0-9\-]{1,50}/", $lastName)) {
            throw new Exception("Impossible d'éditer l'employé, nom de famille incorrect");
        }
        if ($roleId < 0 && !$this->rolesModel->getRole($roleId)) {
            throw new Exception("Impossible d'éditer l'employé, role incorrect");
        }
        if ($placeId < 0 && !$this->placesModel->getPlace($placeId)) {
            throw new Exception("Impossible d'éditer l'employé, Emplacement incorrect");
        }

        $this->employeesModel->updateEmployee($id, $firstName, $lastName, $roleId, $placeId);
        $this->redirect($this->webroot . "Admin");
    }

    public function delete()
    {
        $id = (int)$this->request->getParameter("id");

        $this->employeesModel->deleteEmployee($id);
        $this->redirect($this->webroot . "Admin");
    }
}
