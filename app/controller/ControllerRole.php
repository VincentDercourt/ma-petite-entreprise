<?php
require_once ROOT . '/src/ControllerSecurity.php';
require_once ROOT . '/app/model/Roles.php';
require_once ROOT . '/app/model/Employees.php';
require_once ROOT . '/app/model/Users.php';

class ControllerRole extends ControllerSecurity
{

    private Roles $role;
    private Employees $employee;
    private Users $user;

    public function __construct()
    {
        $this->role = new Roles();
        $this->employee = new Employees();
        $this->user = new Users();
    }

    public function index()
    {
        $this->generateView(
            [
                "view" => "listRole",
                "roles" => $this->role->getRoles()
            ]
        );
    }

    public function add()
    {
        $roleNameEn = (string)$this->request->getParameter("roleNameEn");
        $roleNameFr = (string)$this->request->getParameter("roleNameFr");

        if (!preg_match("/[\w\d\W]{1,100}/", $roleNameEn)) {
            throw new Exception("Impossible d'éditer le role, roleNameEn incorrect. " . htmlspecialchars($roleNameEn));
        }
        if (!preg_match("/[\w\d\W]{1,100}/", $roleNameFr)) {
            throw new Exception("Impossible d'éditer le role, roleNameFr incorrect " . htmlspecialchars($roleNameFr));
        }

        $this->role->addRole($roleNameEn, $roleNameFr);
        $this->redirect($this->webroot . "Role");
    }

    public function editForm()
    {
        $id = (int)$this->request->getParameter("id");
        if (!($role = $this->role->getRole($id))) {
            throw new Exception("Le role {$id} n'existe pas");
        }

        $this->generateView(
            [
                "view" => "editRole",
                "role" => $role
            ]
        );
    }

    public function edit()
    {
        $id = (int)$this->request->getParameter("id");
        $roleNameEn = (string)$this->request->getParameter("roleNameEn");
        $roleNameFr = (string)$this->request->getParameter("roleNameFr");

        if ($id < 0) {
            throw new Exception("Impossible d'éditer l'employé, identifiant incorrect");
        }
        if (!preg_match("/[\w\d\W]{1,100}/", $roleNameEn)) {
            throw new Exception("Impossible d'éditer le role, roleNameEn incorrect. " . htmlspecialchars($roleNameEn));
        }
        if (!preg_match("/[\w\d\W]{1,100}/", $roleNameFr)) {
            throw new Exception("Impossible d'éditer le role, roleNameFr incorrect " . htmlspecialchars($roleNameFr));
        }

        $this->role->updateRole($id, $roleNameEn, $roleNameFr);
        $this->redirect($this->webroot . "Role");
    }

    public function delete()
    {
        $id = (int)$this->request->getParameter("id");

        if ($employee = $this->employee->getEmployeesByRoleId($id)) {
            $roleName = $id;
            if (isset($employee['role_name_en'])) {
                $roleName = $employee['role_name_en'];
            }

            throw new Exception("Veuillez supprimé tout les employés présent dans le role {$roleName}");
        }
        if ($employee = $this->user->getUserByRole($id)) {
            $roleName = $id;
            if (isset($employee['role_name_en'])) {
                $roleName = $employee['role_name_en'];
            }

            throw new Exception("Veuillez supprimé tout les utilisateur présent dans le role {$roleName}");
        }

        $this->role->deleteRole($id);
        $this->redirect($this->webroot . "Role");
    }
}
