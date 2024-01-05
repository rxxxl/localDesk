<?php
require_once "./core/Template.php";
class AdminView
{
    public function home()
    {
        $head = file_get_contents("./public/html/common/head.html");
        $sidebar = file_get_contents("./public/html/common/sidebar.html");
        $home = file_get_contents("./public/html/Admin/home.html");

        $data = array(
            "title" => "Home",
            "bootstrap" => "/public/bootstrap/css/bootstrap.min.css",
            "css_file2" => "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css",
            "font_poppins" => "/public/fonts/poppins.css",
            "css_file" => "/public/css/common/home.css",
            "js_bootstrap" => "/public/bootstrap/js/bootstrap.bundle.min.js",
            "js_file" => "/public/js/home.js"
        );

        $template = new Template($head);
        $head = $template->render($data);

        $template = new Template($sidebar);
        $sidebar = $template->render($data);

        $template = new Template($home);
        $home = $template->render($data);

        echo $head;
        echo $sidebar;
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

}
?>