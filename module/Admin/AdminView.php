<?php
require_once "./core/Template.php";
class AdminView{
    public function home(){
        $home = file_get_contents("./public/html/Admin/home.html");
        $template = new Template($home);
        $home = $template ->render();
        echo $home;
    }

    public function createUser($message){
        $createUser = file_get_contents("./public/html/Admin/createUser.html");
        $template = new Template($createUser);
        
        $data = array(
            "MESSAGE" => $message
        );
        $createUser = $template ->render($data);
        echo $createUser;
    }

    public function createTicket(){
        $createTicket = file_get_contents("./public/html/Admin/createTicket.html");
        
        echo $createTicket;
    }
}
?>