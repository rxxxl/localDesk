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
    public function verifyToken($token)
    {
        $db = new DB();
        $conn = $db->connection();

        $sql = "SELECT COUNT(*) FROM users WHERE token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        $conn->close();

        return $count > 0;
    }


    public function getUserByToken($token)
    {
        $db = new DB();
        $conn = $db->connection();

        $sql = "SELECT email, token FROM users WHERE token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $conn->close();

        return $result->fetch_assoc();
    }

    public function updatePassword($password, $email)
    {
        $db = new DB();
        $conn = $db->connection();

        try {
            $sql = "UPDATE users SET password = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $password, $email);

            $success = $stmt->execute();

            $stmt->close();
            $conn->close();

            if (!$success) {
                throw new Exception("Error al actualizar la contraseña en la base de datos.");
            }

            return $success;
        } catch (Exception $e) {
            // Puedes manejar la excepción según tus necesidades (log, notificación, etc.)
            return false;
        }

    }

    public function deleteToken($email){
        $db = new DB();
        $conn = $db->connection();

        try {
            $sql = "UPDATE users SET token = NULL WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);

            $success = $stmt->execute();

            $stmt->close();
            $conn->close();

            if (!$success) {
                throw new Exception("Error al eliminar el token en la base de datos.");
            }

            return $success;
        } catch (Exception $e) {
            // Puedes manejar la excepción según tus necesidades (log, notificación, etc.)
            return false;
        }
    }

}
?>