<?php
require_once ROOT . '/src/ControllerSecurity.php';
require_once ROOT . '/app/model/Users.php';
require_once ROOT . '/app/model/Roles.php';

class ControllerUser extends ControllerSecurity
{

    private Users $userModel;
    private Roles $roleModel;

    public function __construct()
    {
        $this->userModel = new Users();
        $this->roleModel = new Roles();
    }

    /**
     * @inheritDoc
     */
    public function index()
    {
        $this->generateView(
            [
                "view" => "listUser",
                "users" => $this->userModel->getUsers(),
                "roles" => $this->roleModel->getRoles()
            ]
        );
    }

    public function add()
    {
        $username = (string)$this->request->getParameter("username");
        $password = (string)$this->request->getParameter("password");
        $roleId = (string)$this->request->getParameter("roleId");

        if (!preg_match("/[A-z0-9\-]{1,50}/", $username)) {
            throw new Exception("Impossible d'éditer l'utilisateur, username incorrect");
        }
        if (!preg_match("/[A-z$@#0-9\-]{1,50}/", $password)) {
            throw new Exception("Impossible d'éditer l'utilisateur, password incorrect");
        }
        if ($roleId < 0 && !$this->roleModel->getRole($roleId)) {
            throw new Exception("Impossible d'éditer l'utilisateur, role incorrect");
        }

        $this->userModel->addUser($username, $password, $roleId);
        $this->redirect($this->webroot . "User");
    }

    public function editForm()
    {
        $id = (int)$this->request->getParameter("id");
        if (!($user = $this->userModel->getUserById($id))) {
            throw new Exception("L'utilisateur {$id} n'existe pas");
        }

        $this->generateView(
            [
                "view" => "editUser",
                "user" => $user,
                "roles" => $this->roleModel->getRoles()
            ]
        );
    }

    public function edit()
    {
        $id = (string)$this->request->getParameter("id");
        $username = (string)$this->request->getParameter("username");
        $password = "";
        if ($this->request->issetParameter("password")) {
            $password = (string)$this->request->getParameter("password");
        }
        $roleId = (string)$this->request->getParameter("roleId");

        if (!preg_match("/[A-z0-9\-]{1,50}/", $username)) {
            throw new Exception("Impossible d'éditer l'utilisateur, username incorrect");
        }
        if (!preg_match("/[A-z$@#0-9\-]{0,50}/", $password)) {
            throw new Exception("Impossible d'éditer l'utilisateur, password incorrect");
        }
        if ($roleId < 0 && !$this->roleModel->getRole($roleId)) {
            throw new Exception("Impossible d'éditer l'utilisateur, role incorrect");
        }

        $this->userModel->editUser($id, $username, $password, $roleId);
        $this->redirect($this->webroot . "User");
    }

    public function delete()
    {
        $id = (string)$this->request->getParameter("id");

        $this->userModel->deleteUser($id);
        $this->redirect($this->webroot . "User");
    }
}
