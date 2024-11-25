<?php

require_once "../Classes/Database.php";

class Login extends Database {
   
    public function __construct() {

        parent::__construct();
    }

    public function emailExist($email) {
        $stmt = $this->executeQuery("SELECT email FROM user where email = ?", "s", "../login.php", $email);

        $result_set = $stmt->get_result();

        $stmt->close();
        return $result_set->num_rows > 0;
    }

    private function getPasswordFromDB($email) {
        $stmt = $this->executeQuery("SELECT password FROM user WHERE email = ?", "s", "../login.php", $email);

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
        $stmt = $this->executeQuery("SELECT id, username, profile_image, type FROM user WHERE email = ?", "s", "../login.php", $email);

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