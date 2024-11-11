<?php
require_once "Database.php";

class UserDiscution extends Database {
    public function __construct() {

        parent::__construct();
    }

    public function getUserDiscutions() {
        $query = "SELECT * FROM discution WHERE user_id = ?";

        $stmt = $this->connection->prepare($query);
    
        if ($stmt) {
            $stmt->bind_param("i", $_SESSION['user_id']);
            $result = $stmt->execute();
    
            if ($result) {
                $result_set = $stmt->get_result();
    
                if ($result_set->num_rows > 0) {
                    $row = $result_set->fetch_all(MYSQLI_ASSOC); 
                    return $row;
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

    public function getAllDiscutions() {
        $query = "SELECT * FROM discution";

        $stmt = $this->connection->prepare($query);
    
        if ($stmt) {
            $result = $stmt->execute();
    
            if ($result) {
                $result_set = $stmt->get_result();
    
                if ($result_set->num_rows > 0) {
                    $row = $result_set->fetch_all(MYSQLI_ASSOC); 
                    return $row;
                } else {
                    return false;
                }
            } else {
                $_SESSION['query_error'] = "Error executing query: " . $stmt->error;
                die();
            }
    
            $stmt->close();
        } else {
            $_SESSION['query_error'] = "Error preparing statement: " . $this->connection->error;
            die();
        }
    }

    public function getDiscutionByDiscutionId($discutionId) {
        if(!isset($discutionId) || empty($discutionId)) {
            die("Discution ID can't be emty!");
        }

        $query = "SELECT * FROM discution WHERE id = ?";

        $stmt = $this->connection->prepare($query);
    
        if ($stmt) {
            $stmt->bind_param("i", $discutionId);
            $result = $stmt->execute();
    
            if ($result) {
                $result_set = $stmt->get_result();
    
                if ($result_set->num_rows > 0) {
                    $row = $result_set->fetch_assoc(); 
                    return $row;
                } else {
                    return false;
                }
            } else {
                $_SESSION['query_error'] = "Error executing query: " . $stmt->error;
                die();
            }
    
            $stmt->close();
        } else {
            $_SESSION['query_error'] = "Error preparing statement: " . $this->connection->error;
            die();
        }
    }
}
