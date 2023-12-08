<?php
require_once "./core/Template.php";

class AuthView
{
    public function login($message)
    {
        $login = file_get_contents("./public/html/Auth/login.html");

        $data = array(
            "MESSAGE" => $message
        );

        $template = new Template($login);
        $login = $template->render($data);
        echo $login;
    }

    public function forgotPassword($message)
    {

        $forgotPassword = file_get_contents("./public/html/Auth/forgotPassword.html");

        $data = array(
            "MESSAGE" => $message
        );
        $tempalte = new Template($forgotPassword);
        $forgotPassword = $tempalte->render($data);

        echo $forgotPassword;
    }

    public function resetPasswordForm($message, $user)
    {
        $resetPasswordForm = file_get_contents("./public/html/Auth/resetPasswordForm.html");

        $email = $user["email"];
        $token = $user["token"];
        $data = array(

            "email" => $email,
            "token" => $token,
            "MESSAGE" => $message,
            "js_file" => "/public/js/passwordValidation.js"
        );
        $tempalte = new Template($resetPasswordForm);
        $resetPasswordForm = $tempalte->render($data);

        echo $resetPasswordForm;
    }

}
?>