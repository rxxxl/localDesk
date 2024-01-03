<?php  

require_once "TicketsView.php";
require_once "TicketsModel.php";

require_once "./core/HelpFunctions.php";
require_once "./core/Session.php";


require_once __DIR__ . '/../../module/Common/EmailSender.php';
require "./vendor/autoload.php";
class TicketsController{

    function __construct($method, $arguments)
    {
        if (method_exists($this, $method)) {
            call_user_func(array($this, $method), $arguments);
        } else {
            echo "Method not found, ticket's";
        }
    }

    public function createTicket($arguments = array())
    {
        $ticketModel = new TicketsModel();
        $areas = $ticketModel->getAreas();

        $ticketsView = new TicketsView();
        $ticketsView->createTicket($areas);
    }

    public function saveTicket()
    {
        // Asegúrate de que la solicitud sea una solicitud POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifica si se ha enviado un archivo
            if (isset($_FILES['photo'])) {
                $uploadedFile = $_FILES['photo'];

                // Aquí puedes realizar operaciones adicionales con el archivo, como moverlo a una carpeta de destino
                $uploadDirectory = 'public/images/tickets/';
                $uploadedFilePath = $uploadDirectory . basename($uploadedFile['name']);

                if (move_uploaded_file($uploadedFile['tmp_name'], $uploadedFilePath)) {
                    // El archivo se ha movido correctamente

                    // Obtiene el resto de los datos del formulario
                    $issue = $_POST['issue'];
                    $area = $_POST['area'];
                    $priority = $_POST['priority'];
                    $desireResolutionDate = $_POST['desireResolutionDate'];

                    //id del usuario logeado
                    $userId = $_SESSION['id'];

                    // Aquí puedes realizar operaciones adicionales con los datos del formulario
                    // Por ejemplo, guardarlos en una base de datos
                    $ticketsModel = new TicketsModel();

                    $response = $ticketsModel->saveTicket($issue, $area, $priority, $desireResolutionDate, $uploadedFilePath, $userId);
                    // Si el ticket se guardó exitosamente, envía un correo electrónico con la información del ticket
                    if ($response['success']) {
                        // Crear una instancia de la clase EmailSender
                        $recipientEmail = 'diego.dominguez@dart.biz';
                        //copia a 

                        $subject = 'New ticket';
                        // Construir el cuerpo del correo electrónico con la información del ticket
                        $body = "Nuevo ticket guardado:<br><br>
                            Issue: $issue<br>
                            Area: $area<br>
                            Prioridad: $priority<br>
                            Fecha de resolución deseada: $desireResolutionDate<br>
                            Usuario: $userId<br>
                            Photo: <img src='cid:img'>
                            ";
                        $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/' . $uploadedFilePath;
                        $emailSent = EmailSender::sendEmail($recipientEmail, $subject, $body, null, $imagePath);


                        // Puedes enviar una respuesta JSON de vuelta al cliente
                        echo json_encode(['success' => true, 'message' => 'Ticket saved successfully']);
                    } else {
                        // Puedes enviar una respuesta JSON de vuelta al cliente
                        echo json_encode($response);
                    }

                } else {
                    // Error al mover el archivo
                    $response = ['success' => false, 'message' => 'Error al mover el archivo'];
                    echo json_encode($response);
                }
            } else {
                // No se ha enviado un archivo
                $response = ['success' => false, 'message' => 'Archivo no recibido'];
                echo json_encode($response);
            }
        } else {
            // Si no es una solicitud POST
            $response = ['success' => false, 'message' => 'Método no permitido'];
            echo json_encode($response);
        }
    }

    public function showTickets()
    {
        $ticketsModel = new TicketsModel();
        $tickets = $ticketsModel->getTickets();


        //agregar mensajes por defecto para campos vacios
        foreach ($tickets as &$ticket) {
            $ticket['status'] = $ticket['status'] ?? 'Aún no se ha proporcionado una solución.';
            $ticket['assigned_technician'] = $ticket['assigned_technician'] ?? 'Aún no hay una respuesta.';
            $ticket['resolution_date'] = $ticket['resolution_date'] ?? 'Pendiente';
            $ticket['resolution_time'] = $ticket['resolution_time'] ?? 'Pendiente';
            $ticket['solution'] = $ticket['solution'] ?? 'Pendiente';
            $ticket['response'] = $ticket['response'] ?? 'Pendiente';
            $ticket['rating'] = $ticket['rating'] ?? 'Pendiente';

        }

        $ticketsView = new TicketsView();
        $ticketsView->viewTickets($tickets);
    }

    public function showTicket($arguments = array())
    {
        $ticketId = $arguments[0];

        $ticketsModel = new TicketsModel();
        $ticket = $ticketsModel->getTicketInfo($ticketId);

        $technicians = $ticketsModel->getTechnicians();



        //$ticket['status'] = $ticket['status'] ?? 'Aún no se ha proporcionado una solución.';
        $ticket['assigned_technician'] = $ticket['assigned_technician'] ?? 'Not assigned';
        $ticket['resolution_date'] = $ticket['resolution_date'] ?? 'Pending';
        $ticket['resolution_time'] = $ticket['resolution_time'] ?? 'Pending';
        $ticket['solution'] = $ticket['solution'] ?? 'without solution';
        $ticket['response'] = $ticket['response'] ?? 'No reply';
        $ticket['rating'] = $ticket['rating'] ?? 'unqualified';

        $ticketsView = new ticketsView();
        $ticketsView->viewTicket($ticket, $technicians);
    }
}

?>