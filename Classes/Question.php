<?php
require_once "Database.php";

class Question extends Database{

    public function __construct() {

        parent::__construct();
    }

    public function createQuestion($userId, $discutionId, $question) {
        $query = "INSERT INTO question (user_id, question, discution_id) VALUES (?, ?, ?)";

        $stmt = $this->connection->prepare($query);

        if(!$stmt) {
            $_SESSION['query_error'] = "Error preparing query: " . $this->connection->error;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            die();
        }

        $stmt->bind_param('isi', $userId, $question, $discutionId);
        $result = $stmt->execute();
        
        if(!$result) {
            $_SESSION['query_error'] = "Error registering user: " . $stmt->error;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            die();
        }

        $stmt->close();
        return true;
    }   

    public function getQuestionsFromDiscution($discutionId) {
        $query = "SELECT * FROM question WHERE discution_id = ?";

        $stmt = $this->connection->prepare($query);

        if(!$stmt) {
            $_SESSION['query_error'] = "Error preparing statement: " . $this->connection->error;
            die();
        }

        $stmt->bind_param("i", $discutionId);
        $result = $stmt->execute();
    
        if(!$result) {
            $_SESSION['query_error'] = "Error executing query: " . $stmt->error;
            die();
        }

        $result_set = $stmt->get_result();

        if($result_set->num_rows < 1) {
            return false;
        }
        
        $row = $result_set->fetch_all(MYSQLI_ASSOC); 
        $questionUser = $this->getQuestionUser($row[0]['user_id']);
        $stmt->close();

        return [$row, $questionUser];         
    }

    public function getQuestionUser($userId) {
        $query = "SELECT username, profile_image FROM user WHERE id = ?";

        $stmt = $this->connection->prepare($query);

        if(!$stmt) {
            $_SESSION['query_error'] = "Error preparing statement: " . $this->connection->error;
            die();
        }

        $stmt->bind_param("i", $userId);
        $result = $stmt->execute();
    
        if(!$result) {
            $_SESSION['query_error'] = "Error executing query: " . $stmt->error;
            die();
        }

        $result_set = $stmt->get_result();

        if($result_set->num_rows < 1) {
            return false;
        }
    
        $row = $result_set->fetch_assoc(); 
        $stmt->close();

        return $row;
    }

    public function isInputValid($input) {
        if(!isset($input)) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            $_SESSION['question_error'] = "Inputs can't be empty";
            die();
        }

        $trimmedInput = trim($input);
        if($trimmedInput == '') {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            $_SESSION['question_error'] = "Inputs can't be empty";
            die();
        }
    }
}