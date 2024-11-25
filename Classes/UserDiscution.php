<?php
require_once "Database.php";

class UserDiscution extends Database {
    public function __construct() {

        parent::__construct();
    }

    public function getUserDiscutions() {
        $stmt = $this->executeQuery("SELECT * FROM discution WHERE user_id = ?", "i", "$_SERVER[HTTP_REFERER]", $_SESSION['user_id']);

        $result_set = $stmt->get_result();

        if($result_set->num_rows < 1) {
            return false;
        }
        
        $row = $result_set->fetch_all(MYSQLI_ASSOC); 
        $stmt->close();
        
        return $row;
    }

    public function getAllDiscutions() {
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "index.php";

        $stmt = $this->executeQuery("SELECT * FROM discution", null, $referer, null);

        $result_set = $stmt->get_result();

        if($result_set->num_rows < 1) {
            return false;
        }

        $row = $result_set->fetch_all(MYSQLI_ASSOC); 
        $stmt->close();

        return $row;
    }

    public function getDiscutionByDiscutionId($discutionId) {
        $stmt = $this->executeQuery("SELECT * FROM discution WHERE id = ?", "i", "$_SERVER[HTTP_REFERER]", $discutionId);

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
