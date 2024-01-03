<?php

require_once "./core/Template.php";
class TicketsView
{
    public function createTicket($areas)
    {
        $createTicket = file_get_contents("./public/html/Tickets/createTicket.html");
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
        $viewTickets = file_get_contents("./public/html/Tickets/viewTickets.html");
        $template = new Template($viewTickets);

        $viewTickets = $template->render_regex($tickets, "tickets");

        echo $viewTickets;
    }

    public function viewTicket($ticket, $technicians)
    {
        $viewTicket = file_get_contents("./public/html/Tickets/viewTicket.html");
        $template = new Template($viewTicket);

        $viewTicket = $template->render_regex($technicians, "technicians");

        $template = new Template($viewTicket);
        $viewTicket = $template->render($ticket);

        echo $viewTicket;
    }

}
?>