<?php
require_once "../Classes/Database.php";

class Register extends Database{

    public function __construct() {
       
        //poziva __constructor iz parent klase, gde nam se podesava vrednost $this->connection 
        parent::__construct();
    }

    public function checkIfUsernameExist($username) {
        $stmt = $this->executeQuery("SELECT username FROM user WHERE username = ?", "s", "../register.php", $username);

        $result_set = $stmt->get_result();
        
        $stmt->close();
        return $result_set->num_rows > 0;
    }

    public function checkIfEmailExist($email) {
        $stmt = $this->executeQuery("SELECT email FROM user WHERE email = ?", "s", "../register.php", $email);

        $result_set = $stmt->get_result();
         
        $stmt->close();
        return $result_set->num_rows > 0;
    }

    public function registerUser($username, $email, $password, $type) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->executeQuery("INSERT INTO user (username, email, password, type) VALUES (?, ?, ?, ?)", "ssss", "../register.php", $username, $email, $passwordHash, $type);

        $stmt->close();
        $_SESSION['success_register'] = "User registered successfully!";
        header("Location: ../index.php?success_register");
        die();
    }
}