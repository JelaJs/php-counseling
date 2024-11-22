<?php

require_once "Database.php";

class Login extends Database {
   
    public function __construct() {

        parent::__construct();
    }

    public function emailExist($email) {
        $sql = "SELECT email FROM user where email = ?";

        $stmt = $this->connection->prepare($sql);

        if(!$stmt) {
            $_SESSION['query_error'] = "Error preparing statement: " . $this->connection->error;
            return false;
        }

        $stmt->bind_param("s", $email);
        $result = $stmt->execute();

        if(!$result) {
            $_SESSION['query_error'] = "Error executing query: " . $stmt->error;
            return false;
        }

        $result_set = $stmt->get_result();

        if($result_set->num_rows < 1) {
            return false;
        }

        $stmt->close();
        return true;
    }

    private function getPasswordFromDB($email) {
        $sql = "SELECT password FROM user WHERE email = ?";
        $stmt = $this->connection->prepare($sql);

        if(!$stmt) {
            $_SESSION['query_error'] = "Error preparing statement: " . $this->connection->error;
            return false;
        }

        $stmt->bind_param("s", $email);
        $result = $stmt->execute();

        if(!$result) {
            $_SESSION['query_error'] = "Error executing query: " . $stmt->error;
            return false;
        }

        $result_set = $stmt->get_result();

        if($result_set->num_rows < 1) {
            return false;
        }
               
        $row = $result_set->fetch_assoc(); 
        $stmt->close();
        return $row['password'];        
    }

    public function isPasswordValid($email, $password) {
        $userHashPassword = $this->getPasswordFromDB($email);
        return password_verify($password, $userHashPassword);
    }

    public function loginUser($email) {
        $sql = "SELECT id, username, profile_image, type FROM user WHERE email = ?";
        $stmt = $this->connection->prepare($sql);

        if(!$stmt) {
            $_SESSION['query_error'] = "Error preparing statement: " . $this->connection->error;
            header("Location: ../login.php");
            die();
        }

        $stmt->bind_param("s", $email);
        $result = $stmt->execute();

        if(!$result) {
            $_SESSION['query_error'] = "Error executing query: " . $stmt->error;
            header("Location: ../login.php");
            die();
        }

        $result_set = $stmt->get_result();

        if($result_set->num_rows < 1) {
            header("Location: ../login.php");
            die();
        }
        
        $row = $result_set->fetch_assoc(); 

        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['profile_image'] = $row['profile_image'];
        $_SESSION['type'] = $row['type'];

        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
        $stmt->close();

        header("Location: ../index.php");
        die();
    }
}