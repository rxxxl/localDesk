<?php
require_once "AdminView.php";
require_once "AdminModel.php";
require_once "./core/HelpFunctions.php";
require_once "./core/Session.php";


require_once __DIR__ . '/../../module/Common/EmailSender.php';
require "./vendor/autoload.php";
class AdminController
{
    function __construct($method, $arguments)
    {
        if (method_exists($this, $method)) {
            call_user_func(array($this, $method), $arguments);
        } else {
            echo "Method not found";
        }
    }

    public function home()
    {
        $adminView = new AdminView();
        $adminView->home();   

    }

    public function createUser($arguments = array())
    {

        $message = "";
        switch (true) {
            case (count($arguments) > 0 && $arguments[0] == "error"):
                $message = "The email already exists";
                break;

            case (count($arguments) > 0 && $arguments[0] == "error_duplicate"):
                $message = "Sorry, the email already exists";
                break;

            case (count($arguments) > 0 && $arguments[0] == "success"):
                $message = "User created successfully";
                break;

            // Agrega más casos según sea necesario
            // ...

            default:
                $message = "";
                break;
        }

        $adminModel = new AdminModel();
        $roles = $adminModel->getRoles();
        $areas = $adminModel->getAreas();
        $jobProfiles = $adminModel->getJobProfiles();

        $adminView = new AdminView();
        $adminView->createUser($message, $roles, $areas, $jobProfiles);
    }

    public function saveUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = test_input($_POST["email"]);
            $name = test_input($_POST["name"]);
            $password = test_input($_POST["password"]);
            $jobprofile = test_input($_POST["jobprofile"]);
            $area = test_input($_POST["area"]);
            $rol = test_input($_POST["rol"]);


            if (empty($email) || empty($name) || empty($password) || empty($jobprofile) || empty($area) || empty($rol)) {
                header("Location: /admin/createUser/error");
                exit();
            }


            $adminModel = new AdminModel();
            $adminModel->createUser($email, $name, $password, $jobprofile, $area, $rol);
            header("Location: /admin/createUser/success");
            exit();
        } else {
            $adminView = new AdminView();
            $adminView->createUser();
        }
    }

    public function createTicket($arguments = array())
    {

        $adminModel = new AdminModel();
        $areas = $adminModel->getAreas();



        $adminView = new AdminView();
        $adminView->createTicket($areas);
    }

    public function saveTicket()
    {
        Session()->verifySession("1");

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
                    $adminModel = new AdminModel();

                    $response = $adminModel->saveTicket($issue, $area, $priority, $desireResolutionDate, $uploadedFilePath, $userId);
                    // Si el ticket se guardó exitosamente, envía un correo electrónico con la información del ticket
                    if ($response['success']) {
                        // Crear una instancia de la clase EmailSender
                        $recipientEmail = 'diego.dominguez@dart.biz';
                        $subject = 'New ticket';
                        // Construir el cuerpo del correo electrónico con la información del ticket
                        $body = "Nuevo ticket guardado:<br><br>
                            Issue: $issue<br>
                            Area: $area<br>
                            Prioridad: $priority<br>
                            Fecha de resolución deseada: $desireResolutionDate<br>
                            Usuario: $userId<br>
                            Phto: <img src='cid:img' alt='img'>
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
        $adminModel = new AdminModel();
        $tickets = $adminModel->getTickets();

      
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

        $adminView = new AdminView();
        $adminView->viewTickets($tickets);
    }

    public function showTicket($arguments = array())
    {
        $ticketId = $arguments[0];

        $adminModel = new AdminModel();
        $ticket = $adminModel->getTicketInfo($ticketId);

        $ticket['status'] = $ticket['status'] ?? 'Aún no se ha proporcionado una solución.';
        $ticket['assigned_technician'] = $ticket['assigned_technician'] ?? 'Aún no hay una respuesta.';
        $ticket['resolution_date'] = $ticket['resolution_date'] ?? 'Pendiente';
        $ticket['resolution_time'] = $ticket['resolution_time'] ?? 'Pendiente';
        $ticket['solution'] = $ticket['solution'] ?? 'Pendiente';
        $ticket['response'] = $ticket['response'] ?? 'Pendiente';
        $ticket['rating'] = $ticket['rating'] ?? 'Pendiente';

        $adminView = new AdminView();
        $adminView->viewTicket($ticket);
    }

    






}
?>