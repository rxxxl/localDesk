<?php

require_once "AuthView.php";
require_once "AuthModel.php";
require_once "./core/HelpFunctions.php";
require_once "./core/Session.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "./vendor/autoload.php";

class AuthController
{

    function __construct($method, $arguments)
    {
        if (method_exists($this, $method)) {
            call_user_func(array($this, $method), $arguments);
        } else {
            echo "Resource does not exist";
        }
    }

    public function login($arguments = array())
    {
        $message = "";
        if (count($arguments) > 0 && $arguments[0] == "error") {
            $message = "Invalid credentials";
        }
        if (count($arguments) > 0 && $arguments[0] == "error_empty") {
            $message = "Empty fields";
        }
        if (count($arguments) > 0 && $arguments[0] == "password_updated") {
            $message = "Password updated successfully";
        }


        $authView = new authView();
        $authView->login($message);
    }

    public function verifyUser()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $email = test_input(trim($_POST["email"]));
            $password = test_input($_POST["password"]);

            if (empty($email) || empty($password)) {
                header("Location: /auth/login/error_empty");
                exit();
            }

            //search user in the model
            $authModel = new AuthModel();
            $user = $authModel->getUserByEmail($email);


            if ($user && password_verify($password, $user['password'])) {
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

    public function forgotPassword($arguments = array())
    {
        $message = "";
        if (count($arguments) > 0 && $arguments[0] == "error_email") {
            $message = "Email not found or invalid";
        }
        if (count($arguments) > 0 && $arguments[0] == "success") {
            $message = "Email sent";
        }
        if (count($arguments) > 0 && $arguments[0] == "error_token") {
            $message = "Invalid token";
        }


        $authView = new authView();
        $authView->forgotPassword($message);
    }

    public function resetPassword()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            //recibimos el email 
            $email = test_input(trim($_POST["email"]));

            //comprobamos que email exista
            $authModel = new AuthModel();
            $user = $authModel->getUserByEmail($email);

            if ($user) {
                //generamos un token
                $token = bin2hex(random_bytes(64));


                $authModel->saveToken($token, $email);

                //send email 
                $mail = new PHPMailer(true);

                try {
                    // Configura los ajustes del servidor SMTP
                    $mail->SMTPDebug = 2; // Activa la salida de depuración detallada
                    $mail->isSMTP(); // Envía utilizando SMTP
                    $mail->Host = 'mail.ddm1078.com.mx'; // Servidor SMTP para enviar a través de
                    $mail->SMTPAuth = true; // Habilita la autenticación SMTP
                    $mail->Username = 'localdesk@ddm1078.com.mx'; // Nombre de usuario SMTP
                    $mail->Password = 'Tolucacampeon.2023'; // Contraseña SMTP
                    $mail->SMTPSecure = 'ssl'; // Habilita la encriptación implícita TLS
                    $mail->Port = 465; // Puerto TCP al que conectarse

                    // Configura los detalles del remitente y destinatario
                    $mail->setFrom('localdesk@ddm1078.com.mx', 'Local Desk');
                    $mail->addAddress($email); // Agrega el destinatario del correo electrónico

                    // Contenido del correo electrónico
                    $mail->isHTML(true); // Establece el formato del correo electrónico a HTML
                    $mail->Subject = 'Password reset request';
                    $mail->Body = "Hi, click <a href='localdesk.local/auth/resetPasswordForm/$token'>here</a> to reset your password";

                    // Envía el correo electrónico
                    $mail->send();

                    // El correo electr ónico se envió correctamente
                    echo 'Message has been sent';

                    header("Location: /auth/forgotPassword/success");
                } catch (Exception $e) {
                    // Error al enviar el correo electrónico
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                header("Location: /auth/forgotPassword/error_email");
                exit();
            }


        }

    }

    public function resetPasswordForm($arguments = array())
    {
        $message = "";
        $token = $arguments[0];

        if (count($arguments) > 0 && $arguments[0] == "error_token") {
            $message = "Invalid token";
        }
        //if (count($arguments) > 0 && $arguments[1] == "error_passwords") {
        //  $message = "Passwords do not match";
        //}


        //Verificar si el token existe en la base de datos
        $authModel = new AuthModel();
        $user = $authModel->getUserByToken($token);

        if (!$user) {
            header("Location: /auth/forgotPassword/error_token");
            exit();
        }


        $authView = new authView();
        $authView->resetPasswordForm($message, $user);
    }

    public function updatePassword()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            //recibimos el email 
            $email = test_input(trim($_POST["email"]));
            $token = test_input(trim($_POST["token"]));
            $password = test_input($_POST["password"]);
            $password2 = test_input($_POST["password_confirmation"]);

            if (empty($email) || empty($token) || empty($password) || empty($password2)) {
                echo "empty fields";
                //
                exit();
            }

            if ($password != $password2) {
                header("Location: /auth/resetPasswordForm/" . $token . "/error_passwords");
                exit();
            }

            //verify token
            $authModel = new AuthModel();
            $user = $authModel->getUserByToken($token);

            if (!$user) {
                header("Location: /auth/forgotPassword/error_token");
                exit();
            }

            //encrypt password
            $password = password_hash($password, PASSWORD_DEFAULT);

            //update password in the database
            $authModel->updatePassword($password, $email);

            //if the password was updated, delete the token
            $authModel->deleteToken($email);


            //redirigir al login
            header("Location: /auth/login/password_updated");
            exit();
        }
    }



    public function logout()
    {
        $session = new Session();
        $session->destroySession();
    }



}

?>