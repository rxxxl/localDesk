<?php

require_once('./core/DB.php');
class AdminModel
{
    public function createUser($email, $name, $password, $jobprofile, $area, $rol)
    {
        // Verificar si el correo ya existe en la base de datos
        if ($this->isEmailExists($email)) {
            header("Location: /admin/createUser/error_duplicate");
            exit();
        }

        // Encripta la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $db = new DB();
        $conn = $db->connection();
        $sql = "INSERT INTO users (email, name, password, jobprofile, area, rol) 
            VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $email, $name, $hashedPassword, $jobprofile, $area, $rol);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: /admin/createUser/success");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }


    // Función para verificar si el correo ya existe
    private function isEmailExists($email)
    {
        $db = new DB();
        $conn = $db->connection();
        $sql = "SELECT COUNT(*) FROM users WHERE email = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        $conn->close();

        return $count > 0;
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


    public function saveTicket($issue, $area, $priority, $desireResolutionDate, $uploadedFilePath){

    }
   

}
?>