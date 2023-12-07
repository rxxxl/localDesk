<?php
require_once('./core/DB.php');

class AuthModel
{

    public function getUserByEmail($email)
    {
        $db = new DB();
        $conn = $db->connection();

        $sql = "SELECT * FROM users WHERE email = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $stmt->close();
            $conn->close();
            return $user;
        } else {
            $stmt->close();
            $conn->close();
            return null; // Return null if no user is found
        }
    }

    public function saveToken($token, $email)
    {
        $db = new DB();
        $conn = $db->connection();

        try {
            $sql = "UPDATE users SET token = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $token, $email);

            $success = $stmt->execute();

            $stmt->close();
            $conn->close();

            if (!$success) {
                throw new Exception("Error al actualizar el token en la base de datos.");
            }

            return $success;
        } catch (Exception $e) {
            // Puedes manejar la excepción según tus necesidades (log, notificación, etc.)
            return false;
        }
    }


}
?>