<?php

require_once "AuthView.php";
require_once "AuthModel.php";
require_once "./core/HelpFunctions.php";
require_once "./core/Session.php";

class AuthController {

    function __construct($method, $arguments) {
        if(method_exists($this, $method)) {
            call_user_func(array($this, $method), $arguments);
        } else {
            echo "Resource does not exist";
        }
    }

    public function login($arguments = array()) {
        $message = "";
        if(count($arguments) > 0 && $arguments[0] == "error") {
            $message = "Invalid credentials";
        }
        if(count($arguments) > 0 && $arguments[0] == "error_empty") {
            $message = "Empty fields";
        }


        $authView = new authView();
        $authView->login($message);
    }

    public function verifyUser() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {

            $email = test_input(trim($_POST["email"]));
            $password = test_input($_POST["password"]);

            if(empty($email) || empty($password)) {
                header("Location: /auth/login/error_empty");
                exit();
            }

            //search user in the model
            $authModel = new AuthModel();
            $user = $authModel->getUserByEmail($email);

            if($user && password_verify($password, $user['password'])) {
                $session = new Session();
                $session->createSession($user['rol'], $user['email']);

            } else {
                header("Location: /auth/login/error");
                exit();
            }
        } else {
            header("Location: /auth/login/error");
            exit();
        }
    }

    public function forgotPassword($arguments = array()) {
        $message = "";
        if(count($arguments) > 0 && $arguments[0] == "error_email") {
            $message = "Email not found or invalid";
        }


        $authView = new authView();
        $authView->forgotPassword($message);
    }

    public function resetPassword() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            //recibimos el email 
            $email = test_input(trim($_POST["email"]));

            //comprobamos que email exista
            $authModel = new AuthModel();
            $user = $authModel->getUserByEmail($email);

            if($user) {
                //generamos un token
                $token = bin2hex(random_bytes(64));

                
                $authModel->saveToken($token, $email);

                
                
                
            } else {
                header("Location: /auth/forgotPassword/error_email");
                exit();
            }


        }

    }



    public function logout() {
        $session = new Session();
        $session->destroySession();
    }



}

?>