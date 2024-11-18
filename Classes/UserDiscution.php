<?php
require_once "Database.php";

class UserDiscution extends Database {
    public function __construct() {

        parent::__construct();
    }

    public function getUserDiscutions() {
        $query = "SELECT * FROM discution WHERE user_id = ?";

        $stmt = $this->connection->prepare($query);

        if(!$stmt) {
            $_SESSION['query_error'] = "Error preparing statement: " . $this->connection->error;
            return false;
        }

        $stmt->bind_param("i", $_SESSION['user_id']);
        $result = $stmt->execute();

        if(!$result) {
            $_SESSION['query_error'] = "Error executing query: " . $stmt->error;
            return false;
        }

        $result_set = $stmt->get_result();

        if($result_set->num_rows < 1) {
            return false;
        }
        
        $row = $result_set->fetch_all(MYSQLI_ASSOC); 
        $stmt->close();
        
        return $row;
    }

    public function getAllDiscutions() {
        $query = "SELECT * FROM discution";

        $stmt = $this->connection->prepare($query);
    
        if(!$stmt) {
            $_SESSION['query_error'] = "Error preparing statement: " . $this->connection->error;
            return false;
        }

        $result = $stmt->execute();

        if(!$result) {
            $_SESSION['query_error'] = "Error executing query: " . $stmt->error;
            return false;
        }

        $result_set = $stmt->get_result();

        if($result_set->num_rows < 1) {
            return false;
        }

        $row = $result_set->fetch_all(MYSQLI_ASSOC); 
        $stmt->close();

        return $row;
    }

    public function getDiscutionByDiscutionId($discutionId) {
        if(!isset($discutionId) || empty($discutionId)) {
            die("Discution ID can't be emty!");
        }

        $query = "SELECT * FROM discution WHERE id = ?";

        $stmt = $this->connection->prepare($query);

        if(!$stmt) {
            $_SESSION['query_error'] = "Error preparing statement: " . $this->connection->error;
            return;
        }

        $stmt->bind_param("i", $discutionId);
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
        return $row;
    }

    /*
    public function getDiscutionQuestionsAndAnswersByDiscutionId($discutionId) {
        if(!isset($discutionId) || empty($discutionId)) {
            die("Discution ID can't be emty!");
        }

        $query = "SELECT 
                d.*, 
                q.*, 
                a.*
                FROM 
                    discution d
                LEFT JOIN 
                    question q ON d.id = q.discution_id
                LEFT JOIN 
                    answer a ON d.id = a.discution_id
                WHERE 
                    d.id = ?";

        $stmt = $this->connection->prepare($query);

        if(!$stmt) {
            $_SESSION['query_error'] = "Error preparing statement: " . $this->connection->error;
            return false;
        }

        $stmt->bind_param("i", $discutionId);
        $result = $stmt->execute();

        if(!$result) {
            $_SESSION['query_error'] = "Error executing query: " . $stmt->error;
            return false;
        }

        $result_set = $stmt->get_result();

        if($result_set->num_rows < 1) {
            return false;
        }
            
        $row = $result_set->fetch_All(MYSQLI_ASSOC); 
        $stmt->close();  
        return $row;
    }*/
}
