<?php
session_start();

class Session
{
    public function createSession($login, $email, $id)
    {
        $_SESSION['login'] = $login; //tipo de usuario que se ha logeado al sistema
        $_SESSION['email'] = $email;
        $_SESSION['id'] = $id;

        switch ($_SESSION['login']) {
            case '1':
                header('Location: /admin/home');
                break;
            default:
                header('Location: /user/home');
                break;
        }
        exit();
    }

    public function verifySession($rol)
    {
        if (!isset($_SESSION['login']) || $_SESSION['login'] != $rol) {
            $this->destroySession();
        }
    }

    public function destroySession()
    {
        session_destroy();
        header('Location: /user/login');
        exit();
    }

    public function isLogged()
    {
        return isset($_SESSION['login']);
    }
}

function Session()
{
    return new Session();
}
?>