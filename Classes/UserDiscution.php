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

    public function mergeAndSortQuestionsAndAnswers($discutionQuestions, $discutionAnswers) {
        $mergedArr = array_merge($discutionQuestions, $discutionAnswers);

        usort($mergedArr, function($a, $b) {
            $timeA = strtotime($a['created_at']) * 1000; //in miliseconds
            $timeB = strtotime($b['created_at']) * 1000;
        
            return $timeA <=> $timeB;
        });

        return $mergedArr;
    }
}
