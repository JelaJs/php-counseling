<?php
require_once "Database.php";

class Register extends Database{

    public function __construct() {
       
        //poziva __constructor iz parent klase, gde nam se podesava vrednost $this->connection 
        parent::__construct();
    }

    public function checkIfUsernameExist($username) {
        $query = "SELECT username FROM user WHERE username = ?";
        $stmt = $this->connection->prepare($query);

        if(!$stmt) {
            $_SESSION['username_query_error'] = "Error preparing statement: " . $this->connection->error;
            return false;
        }

        $stmt->bind_param("s", $username);
        $result = $stmt->execute();

        if(!$result) {
            $_SESSION['username_query_error'] = "Error executing query: " . $stmt->error;
            return false;
        }

        $result_set = $stmt->get_result();

        if($result_set->num_rows > 0) {
            return true;
        }

        $stmt->close();        
        return false;
    }

    public function checkIfEmailExist($email) {
        $query = "SELECT email FROM user WHERE email = ?";
        $stmt = $this->connection->prepare($query);
    
        if(!$stmt) {
            $_SESSION['email_query_error'] = "Error preparing statement: " . $this->connection->error;
            return false;
        }

        $stmt->bind_param("s", $email);
        $result = $stmt->execute();

        if(!$result) {
            $_SESSION['email_query_error'] = "Error executing query: " . $stmt->error;
            return false;
        }

        $result_set = $stmt->get_result();
        
        if($result_set->num_rows > 0) {
            return true;
        }
        
        $stmt->close();    
        return false;
    }

    public function registerUser($username, $email, $password, $type) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO user (username, email, password, type) VALUES (?, ?, ?, ?)";
    
        $stmt = $this->connection->prepare($query);

        if(!$stmt) {
            $_SESSION['query_error'] = "Error preparing query: " . $this->connection->error;
            header("Location: ../register.php");
            die();
        }

        $stmt->bind_param('ssss', $username, $email, $passwordHash, $type);
        $result = $stmt->execute();

        if(!$result) {
            $_SESSION['query_error'] = "Error registering user: " . $stmt->error;
            header("Location: ../register.php");
            die();
        }
     
        $_SESSION['success_register'] = "User registered successfully!";
        header("Location: ../index.php?success_register");

        $stmt->close();
    }
}