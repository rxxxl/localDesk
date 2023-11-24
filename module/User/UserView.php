<?php
require_once "./core/Template.php";
    class UserView{
        public function dashboard()
        {
            $dashboard = file_get_contents("./public/html/User/dashboard.html");
            $template = new Template($dashboard);
            $dashboard = $template ->render($dashboard);

            echo $dashboard;

        }
    }
?>