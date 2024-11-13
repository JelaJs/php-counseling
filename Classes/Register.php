<?php
require_once "Database.php";

class Register extends Database{
    private $username;
    private $email;
    private $type;
    private $password;


    public function __construct($username, $email, $type, $password) {
        $this->username = $username;
        $this->email = $email;
        $this->type = $type;
        $this->password = $password;

        //poziva __constructor iz parent klase, gde nam se podesava vrednost $this->connection 
        parent::__construct();
    }

    public function isUserLoggedIn() {

        if(isset($_SESSION['user_id'])) {
            header("Location: ../index.php");
        }
    }

    private function areInputsValid() {
        $this->isUsernameFieldValid();
        $this->isEmailFieldValid();
        $this->isTypeFieldValid();
        $this->isPasswordFieldValid();

        return true;
    }   

    private function isUsernameFieldValid() {
        if(!isset($this->username) || empty($this->username)) {
            $_SESSION['input_error'] = "Username can't be empty";
            header("Location: ../register.php");
            die();
        }

        if(strlen($this->username) < 4) {
            $_SESSION['input_error'] = "Username needs to be at least 4 charachters long";
            header("Location: ../register.php");
            die();
        }

        if(strpos($this->username, ' ')) {
            $_SESSION['input_error'] = "You can't use space(' ') in username field";
            header("Location: ../register.php");
            die();
        }

        if($this->checkIfUsernameExist() && !isset($_SESSION['query_error'])) {
            $_SESSION['input_error'] = "User with this username already exist";
            header("Location: ../register.php");
            die();
        } 

        if(isset($_SESSION['query_error'])) {
            header("Location: ../register.php");
            die();
        }
    }

    private function isTypeFieldValid() {
        if(!isset($this->type) || empty($this->type)) {
            $_SESSION['input_error'] = "Type can't be empty";
            header("Location: ../register.php");
            die();
        }

        if($this->type !== "listener" && $this->type !== "advisor") {
            $_SESSION['input_error'] = "The type can be either listener or advisor";
            header("Location: ../register.php");
            die();
        }
    }

    private function isEmailFieldValid() {
        if(!isset($this->email) || empty($this->email)) {
            $_SESSION['input_error'] = "Email can't be empty";
            header("Location: ../register.php");
            die();
        }

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['input_error'] = "Invalid Email format";
            header("Location: ../register.php");
            die();
        }

        if($this->checkIfEmailExist() && !isset($_SESSION['query_error'])) {
            $_SESSION['input_error'] = "User with this email already exist";
            header("Location: ../register.php");
            die();
        } 

        if(isset($_SESSION['query_error'])) {
            header("Location: ../register.php");
            die();
        }
    }

    private function isPasswordFieldValid() {
        if(!isset($this->password) || empty($this->password)) {
            $_SESSION['input_error'] = "Password can't be empty";
            header("Location: ../register.php");
            die();
        }

        if(!$this->validatePasswordFieldRules($this->password)) {
            $_SESSION['input_error'] = "Password needs to be at least 6 charachters long and needs to have at least one big letter";
            header("Location: ../register.php");
            die();
        }
    }

    private function validatePasswordFieldRules($password) {
        return preg_match('/^(?=.*[A-Z]).{6,}$/', $password);
    }

    private function checkIfUsernameExist() {
        $query = "SELECT username FROM user WHERE username = ?";
        $stmt = $this->connection->prepare($query);
    
        if ($stmt) {
            $stmt->bind_param("s", $this->username);
            $result = $stmt->execute();
    
            if ($result) {
                $result_set = $stmt->get_result();
    
                if ($result_set->num_rows > 0) {
                    $row = $result_set->fetch_assoc(); 
                    return $row['username'];
                } else {
                    return false;
                }
            } else {
                $_SESSION['query_error'] = "Error executing query: " . $stmt->error;
                return;
            }
    
            $stmt->close();
        } else {
            $_SESSION['query_error'] = "Error preparing statement: " . $this->connection->error;
            return;
        }
    }

    private function checkIfEmailExist() {
        $query = "SELECT email FROM user WHERE email = ?";
        $stmt = $this->connection->prepare($query);
    
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
                return;
            }
    
            $stmt->close();
        } else {
            $_SESSION['query_error'] = "Error preparing statement: " . $this->connection->error;
            return;
        }
    }

    public function registerUser() {
        $validInputs = $this->areInputsValid();

        if($validInputs) {
            $this->createUser();
        }
    }

    private function createUser() {
        $password = password_hash($this->password, PASSWORD_BCRYPT);
        $query = "INSERT INTO user (username, email, password, type) VALUES (?, ?, ?, ?)";
    
        $stmt = $this->connection->prepare($query);
    
        if ($stmt) {
            $stmt->bind_param('ssss', $this->username, $this->email, $password, $this->type);
    
            $result = $stmt->execute();
    
            if ($result) {
                $_SESSION['success_register'] = "User registered successfully!";
                header("Location: ../index.php?success_register");
            } else {
                // Handle error during query execution
                $_SESSION['query_error'] = "Error registering user: " . $stmt->error;
                header("Location: ../register.php");
                die();
            }
    
            $stmt->close();
        } else {
            $_SESSION['query_error'] = "Error preparing query: " . $this->connection->error;
            header("Location: ../register.php");
            die();
        }
    }
}