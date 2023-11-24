<?php
    class AdminController{
        function __construct($method, $arguments){
            if(method_exists($this, $method)){
                call_user_func(array($this, $method), $arguments);
            }else{
                echo "Method not found";
            }
        }

        public function dashboard(){
            echo "Admin dashboard";
        }
    }
?>