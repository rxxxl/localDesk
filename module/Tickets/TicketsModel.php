<?php

require_once('./core/DB.php');

class TicketsModel{
    
    public function findTicket($id){
        $db = new DB();
        $conn = $db->connection();
        $sql = "SELECT * FROM tickets WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $conn->close();

        return $result;
    }
    
    public function getRoles()
    {
        $db = new DB();
        $conn = $db->connection();
        $sql = "SELECT * FROM roles";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $conn->close();

        return $result;
    }

    public function getAreas()
    {
        $db = new DB();
        $conn = $db->connection();
        $sql = "SELECT * FROM areas";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $conn->close();

        return $result;
    }

    public function getJobProfiles()
    {
        $db = new DB();
        $conn = $db->connection();
        $sql = "SELECT * FROM job_profiles";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $conn->close();

        return $result;
    }


    public function saveTicket($issue, $area, $priority, $desireResolutionDate, $uploadedFilePath, $userId)
    {
        $db = new DB();
        $conn = $db->connection();
        $sql = "INSERT INTO tickets (issue, area, priority, desired_resolution_date, photo_route, created_by) 
            VALUES (?, ?, ?, ?, ?, ?)";

        try {
            $conn->begin_transaction();

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $issue, $area, $priority, $desireResolutionDate, $uploadedFilePath, $userId);

            if ($stmt->execute()) {
                $stmt->close();
                // Commit la transacción si todo fue exitoso
                $conn->commit();

                $response = [
                    'success' => true,
                    'message' => 'Ticket saved successfully',
                    'data' => [
                        'userId' => $userId,
                        'issue' => $issue,
                        'area' => $area,
                        'priority' => $priority,
                        'desireResolutionDate' => $desireResolutionDate,
                        'photo' => $uploadedFilePath
                    ]
                ];
            } else {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }
        } catch (Exception $e) {
            // Manejo de la excepción (puedes loguear el error, lanzar otra excepción, etc.)
            $response = ['success' => false, 'message' => 'Error al guardar el ticket', 'error' => $e->getMessage()];
            $conn->rollback(); // Rollback en caso de error
        } finally {
            $conn->close();
        }

        return $response;
    }


    public function getUserInfo($userId)
    {
        $db = new DB();
        $conn = $db->connection();
        $sql = "SELECT * FROM users WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $conn->close();

        return $result;
    }

    public function getTickets()
    {
        $db = new DB();
        $conn = $db->connection();
        $sql = "SELECT tickets.id,
                areas.area AS area,
                tickets.priority,
                tickets.issue,
                tickets.desired_resolution_date,
                tickets.creation_date,
                tickets.status,
                users_created.name AS created_by,
                users_assigned.name AS assigned_technician,
                tickets.resolution_date,
                tickets.resolution_time,
                tickets.solution,
                tickets.response,
                tickets.rating,
                tickets.photo_route
            FROM tickets
            JOIN areas ON tickets.area = areas.id
            JOIN users AS users_created ON tickets.created_by = users_created.id
            LEFT JOIN users AS users_assigned ON tickets.assigned_technician = users_assigned.id;
            ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $tickets = array();
        while ($row = $result->fetch_assoc()) {
            $tickets[] = $row;
        }


        $stmt->close();
        $conn->close();

        return $tickets;
    }


    //funcion para obtener todos los datos de un ticket seleccionado 
    public function getTicketInfo($ticketId)
    {
        $db = new DB();
        $conn = $db->connection();
        $sql = "SELECT tickets.id,
                areas.area AS area,
                tickets.priority,
                tickets.issue,
                tickets.desired_resolution_date,
                tickets.creation_date,
                tickets.status,
                users_created.name AS created_by,
                users_assigned.name AS assigned_technician,
                tickets.resolution_date,
                tickets.resolution_time,
                tickets.solution,
                tickets.response,
                tickets.rating,
                tickets.photo_route
            FROM tickets
            JOIN areas ON tickets.area = areas.id
            JOIN users AS users_created ON tickets.created_by = users_created.id
            LEFT JOIN users AS users_assigned ON tickets.assigned_technician = users_assigned.id
            WHERE tickets.id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $ticketId);
        $stmt->execute();

        $result = $stmt->get_result();

        $ticket = array();
        if ($result->num_rows > 0) {
            $ticket = $result->fetch_assoc();
        }

        $stmt->close();
        $conn->close();

        return $ticket;
    }

    public function getTechnicians()
    {
        $db = new DB();
        $conn = $db->connection();
        $sql = "SELECT id, email, name FROM users WHERE rol = 1";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $technicians = array();
        while ($row = $result->fetch_assoc()) {
            $technicians[] = $row;
        }

        $stmt->close();
        $conn->close();

        return $technicians;
    }



    public function updateTicket($id, $status, $assigned_technician, $solution)
    {
        $db = new DB();
        $conn = $db->connection();
        $sql = "UPDATE tickets SET status = ?, assigned_technician = ?, solution = ? WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $status, $assigned_technician, $solution, $id);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: /tickets/showTickets");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    public function processTicket($ticketId, $technician, $status){
        $db = new DB();
        $conn = $db->connection();
        $sql = "UPDATE tickets SET status = ?, assigned_technician = ? WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $status, $technician, $ticketId);
        
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: /tickets/showTickets");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    public function solvedTicket($ticketId, $technician, $status, $solution, $resolution_date){
        $db = new DB();
        $conn = $db->connection();
        
        $sql = "UPDATE tickets SET status = ?, assigned_technician = ?, solution = ?, resolution_date = ? WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $status, $technician, $solution, $resolution_date, $ticketId);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: /tickets/showTickets");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }


    }

    public function workingTicket($ticketId, $technician, $status){
        $db = new DB();
        $conn = $db->connection();
        $sql = "UPDATE tickets SET status = ?, assigned_technician = ? WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $status, $technician, $ticketId);
        
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: /tickets/showTickets");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

    }

    

}
?>