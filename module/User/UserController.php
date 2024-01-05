<?php
require_once "UserView.php";
require_once "UserModel.php";
require_once "./core/HelpFunctions.php";
require_once "./core/Session.php";

class UserController
{

    function __construct($method, $arguments)
    {
        if (method_exists($this, $method)) {
            call_user_func(array($this, $method), $arguments);
        } else {
            echo "Resource does not exist";
        }
    }

    


}
?>