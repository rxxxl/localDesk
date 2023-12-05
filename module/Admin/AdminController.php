<?php
require_once "AdminView.php";
require_once "AdminModel.php";
require_once "./core/HelpFunctions.php";
require_once "./core/Session.php";

class AdminController
{
    function __construct($method, $arguments)
    {
        if (method_exists($this, $method)) {
            call_user_func(array($this, $method), $arguments);
        } else {
            echo "Method not found";
        }
    }

    public function home()
    {
        echo "Home";
    }

    public function createUser($arguments = array())
    {

        $message = "";
        switch (true) {
            case (count($arguments) > 0 && $arguments[0] == "error"):
                $message = "The email already exists";
                break;

            case (count($arguments) > 0 && $arguments[0] == "error_duplicate"):
                $message = "Sorry, the email already exists";
                break;

            case (count($arguments) > 0 && $arguments[0] == "success"):
                $message = "User created successfully";
                break;

            // Agrega más casos según sea necesario
            // ...

            default:
                $message = "";
                break;
        }

        $adminView = new AdminView();
        $adminView->createUser($message);
    }

    public function saveUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = test_input($_POST["email"]);
            $name = test_input($_POST["name"]);
            $password = test_input($_POST["password"]);
            $jobprofile = test_input($_POST["jobprofile"]);
            $area = test_input($_POST["area"]);
            $rol = test_input($_POST["rol"]);


            if (empty($email) || empty($name) || empty($password) || empty($jobprofile) || empty($area) || empty($rol)) {
                header("Location: /admin/createUser/error");
                exit();
            }


            $adminModel = new AdminModel();
            $adminModel->createUser($email, $name, $password, $jobprofile, $area, $rol);
            header("Location: /admin/createUser/success");
            exit();
        } else {
            $adminView = new AdminView();
            $adminView->createUser();
        }
    }

    public function createTicket($arguments = array())
    {

        $adminView = new AdminView();
        $adminView->createTicket();
    }

}
?>