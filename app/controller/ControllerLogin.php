<?php
require_once ROOT . '/src/Session.php';
require_once ROOT . '/src/Controller.php';
require_once ROOT . '/app/model/Employees.php';
require_once ROOT . '/app/model/Users.php';

class ControllerLogin extends Controller
{
    private Users $userModel;
    private Session $session;

    public function __construct()
    {
        $this->userModel = new Users();
        $this->session = new Session();
    }

    public function index()
    {
        $this->generateView(["view" => "login"]);
    }

    public function connect()
    {
//        echo __FILE__ . " " . __LINE__ . "<br><pre style='background:black;color:gray;padding:5px 10px'>";
//        print_r($_POST);
//        echo "</pre><br>";
//        extract($_POST);

        $login = $this->request->getParameter("login");
        $password = $this->request->getParameter("mdp");

        if ($user = $this->userModel->getUserByUsername($login)) {
            if (
                isset($user['id']) && isset($user['password']) &&
                password_verify($password, $user['password'])
            ) {
                unset($user['password']);
                $this->session->setAttribut("auth", $user);
            } else {
                throw new Exception("Identifiant incorrect !");
            }
        }

        $this->redirect($this->webroot);

        exit;
    }

    public function logout()
    {
        $this->request->getSession()->destroy();
        $this->redirect($this->webroot . "");
    }
}
