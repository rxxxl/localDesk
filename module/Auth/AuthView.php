<?php
require_once "./core/Template.php";

class AuthView
{
    public function login($message)
    {
        $head = file_get_contents("./public/html/Auth/head.html");
        $login = file_get_contents("./public/html/Auth/loginv2.html");

        $data = array(
            "MESSAGE" => $message, 
            "title" => "Login"
        );

        $headData = array(
            "title" => "Login",
            "bootstrap" => "/public/bootstrap/css/bootstrap.min.css",
            "css_file" => "/public/css/login.css",
            "font" => "/public/css/common/sf-pro-display.css",
            "js_file" => "/public/js/loginValidation.js"
        );

        $template = new Template($head);
        $head = $template->render($headData);

        $template = new Template($login);
        $login = $template->render($data);

        echo $head;
        echo $login;
        
    }

    public function forgotPassword($message)
    {
        $head = file_get_contents("./public/html/Auth/head.html");
        $forgotPassword = file_get_contents("./public/html/Auth/forgotPasswordv2.html");

        $data = array(
            "MESSAGE" => $message,
            "title" => "Forgot password"
        );

        $headData = array(
            "title" => "Login",
            "bootstrap" => "/public/bootstrap/css/bootstrap.min.css",
            "css_file" => "/public/css/login.css",
            "font" => "/public/css/common/sf-pro-display.css",
            "js_file" => "/public/js/loginValidation.js"
        );

        $template = new Template($head);
        $head = $template->render($headData);

        $tempalte = new Template($forgotPassword);
        $forgotPassword = $tempalte->render($data);

        echo $head;
        echo $forgotPassword;
    }

    public function resetPasswordForm($message, $user)
    {
        $head = file_get_contents("./public/html/Auth/head.html");
        $resetPasswordForm = file_get_contents("./public/html/Auth/resetPasswordFormv2.html");

        $email = $user["email"];
        $token = $user["token"];
        $data = array(
            "title" => "Reset password",
            "email" => $email,
            "token" => $token,
            "MESSAGE" => $message,
            "js_file" => "/public/js/passwordValidation.js"
        );

        $headData = array(
            "title" => "Login",
            "bootstrap" => "/public/bootstrap/css/bootstrap.min.css",
            "font" => "/public/css/common/sf-pro-display.css",
            "css_file" => "/public/css/login.css"
        );

        $template = new Template($head);
        $head = $template->render($headData);

        $tempalte = new Template($resetPasswordForm);
        $resetPasswordForm = $tempalte->render($data);

        echo $head;
        echo $resetPasswordForm;
    }

}
?>