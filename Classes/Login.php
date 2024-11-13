<?php

require_once "Database.php";

class Login extends Database {
    private $email;
    private $password;

    public function __construct($email, $password) {
        $this->email = $email;
        $this->password = $password;

        parent::__construct();
    }

    private function areInputsValid() {

        $this->isEmailFieldValid();
        $this->isPasswordFieldValid();

        return true;
    }

    private function isEmailFieldValid() {
        if(!isset($this->email) || empty($this->email)) {
            $_SESSION['input_error'] = "Email can't be empty";
            header("Location: ../login.php");
            die();
        }

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['input_error'] = "Invalid Email format";
            header("Location: ../login.php");
            die();
        }

        if(!$this->emailExist()) {
            $_SESSION['input_error'] = "There is no user with this email address";
            header("Location: ../login.php");
            die();
        }
    }    

    private function isPasswordFieldValid() {
        if(!isset($this->password) || empty($this->password)) {
            $_SESSION['input_error'] = "Password can't be empty";
            header("Location: ../login.php");
            die();
        }

        if($this->getPasswordFromDB()) {
            $password = $this->getPasswordFromDB();

            if(!$this->isPasswordValid($password)) {
               $_SESSION['input_error'] = "Invalid password";
                header("Location: ../login.php");
                die();
            }
            
        }
    }

    private function emailExist() {
        $sql = "SELECT email FROM user where email = ?";

        $stmt = $this->connection->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("s", $this->email);
            $result = $stmt->execute();
    
            if ($result) {
                $result_set = $stmt->get_result();
    
                if ($result_set->num_rows > 0) {
                    $row = $result_set->fetch_assoc(); 
                    return $row['email'];
                } else {
                    return false;
                }
            } else {
                $_SESSION['query_error'] = "Error executing query: " . $stmt->error;
                return false;
            }
    
            $stmt->close();
        } else {
            $_SESSION['query_error'] = "Error preparing statement: " . $this->connection->error;
            return false;
        }
    }

    private function getPasswordFromDB() {
        $sql = "SELECT password FROM user WHERE email = ?";
        $stmt = $this->connection->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $this->email);
            $result = $stmt->execute();
    
            if ($result) {
                $result_set = $stmt->get_result();
    
                if ($result_set->num_rows > 0) {
                    $row = $result_set->fetch_assoc(); 
                    return $row['password'];
                } else {
                    return false;
                }
            } else {
                $_SESSION['query_error'] = "Error executing query: " . $stmt->error;
                return false;
            }
    
            $stmt->close();
        } else {
            $_SESSION['query_error'] = "Error preparing statement: " . $this->connection->error;
            return false;
        }
    }

    public function isPasswordValid($password) {
        return password_verify($this->password, $password);
    }

    public function loginUser() {
        if($this->areInputsValid()) {
            $this->login();
        }
    }

    private function login() {
        $sql = "SELECT id, username, profile_image, type FROM user WHERE email = ?";
        $stmt = $this->connection->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("s", $this->email);
            $result = $stmt->execute();
    
            if ($result) {
                $result_set = $stmt->get_result();
    
                if ($result_set->num_rows > 0) {
                    $row = $result_set->fetch_assoc(); 

                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['profile_image'] = $row['profile_image'];
                    $_SESSION['type'] = $row['type'];

                    $newSessionId = session_create_id();
                    $sessionId = $newSessionId . "_" . $userId;
                    session_id($sessionId);

                    $_SESSION['last_regeneration'] = time();

                    header("Location: ../index.php");
                    die();
                } else {
                    return false;
                }
            } else {
                $_SESSION['query_error'] = "Error executing query: " . $stmt->error;
                return false;
            }
    
            $stmt->close();
        } else {
            $_SESSION['query_error'] = "Error preparing statement: " . $this->connection->error;
            return false;
        }
    }
}