<?php

    require_once "UserView.php";
    class UserController{

        function __construct($method, $arguments)
        {
            if (method_exists($this, $method)) {
                call_user_func(array($this, $method), $arguments);
            } else {
                echo "Resource does not exist";
            }
        }

        public function dashboard()
        {
            $userView = new UserView();
            $userView->dashboard();
        }
    }
?>