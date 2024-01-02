<?php
require_once "./core/Template.php";
class AdminView
{
    public function home()
    {
        $home = file_get_contents("./public/html/Admin/home.html");

      
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

    public function createTicket($areas)
    {
        $createTicket = file_get_contents("./public/html/Admin/createTicket.html");
        $template = new Template($createTicket);

        $data = array(
            "js_file_ticket" => "/public/js/saveTicket.js"
        );

        $createTicket = $template->render_regex($areas, "areas");

        $template = new Template($createTicket);
        $createTicket = $template->render($data);

        echo $createTicket;
    }

    public function viewTickets($tickets)
    {
        $viewTickets = file_get_contents("./public/html/Admin/viewTickets.html");
        $template = new Template($viewTickets);

        $viewTickets = $template->render_regex($tickets, "tickets");

        echo $viewTickets;
    }

    public function viewTicket($ticket, $technicians)
    {
        $viewTicket = file_get_contents("./public/html/Admin/viewTicket.html");
        $template = new Template($viewTicket);

        $viewTicket = $template->render_regex($technicians, "technicians");
        
        $template = new Template($viewTicket);
        $viewTicket = $template->render($ticket);

        echo $viewTicket;
    }

    



}
?>