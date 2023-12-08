<?php
require_once "./core/Template.php";
class AdminView
{
    public function home()
    {
        $home = file_get_contents("./public/html/Admin/home.html");
        $template = new Template($home);
        $home = $template->render();
        echo $home;
    }

    public function createUser($message, $roles, $areas, $jobProfiles)
    {
        $createUser = file_get_contents("./public/html/Admin/createUser.html");
        $template = new Template($createUser);

        $data = array(
            "MESSAGE" => $message
        );

        $template = new Template($createUser);
        $createUser = $template->render_regex($roles, "roles");

        $template = new Template($createUser);
        $createUser = $template->render_regex($areas, "areas");

        $template = new Template($createUser);
        $createUser = $template->render_regex($jobProfiles, "jobProfiles");

        $template = new Template($createUser);
        $createUser = $template->render($data);

        
        echo $createUser;
    }

    public function createTicket()
    {
        $createTicket = file_get_contents("./public/html/Admin/createTicket.html");

        echo $createTicket;
    }
}
?>