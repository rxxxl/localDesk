<?php
session_start();

class Session{
    public function createSession($login, $email, $id){
        $_SESSION['login'] = $login;
        $_SESSION['email'] = $email;
        $_SESSION['id'] = $id;
        switch ($_SESSION['login']) {
            case 'root':
                header('Location: /root/home');
                break;
            case 'admin':
                header('Location: /admin/home');
                break;
            case 'assistant':
                header('Location: /assistant/home');
                break;  
        }
    }

    public function verifySession($rol){
        if ( !isset($_SESSION['login']) || $_SESSION['login'] != $rol ) {
            $this->destroySession();
        }
    }

    public function destroySession(){
        session_destroy();
        header('Location: /user/login');
        exit();
    }
    
    public function isLogged(){
        return isset($_SESSION['login']);
    }
}

function Session(){
    return new Session();
}
?>