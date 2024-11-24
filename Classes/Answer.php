<?php
require_once "Main.php";

class Answer extends Main{

    public function __construct() {

        parent::__construct();
    }

   /* public function createAnswer($discutionId, $answer) {
        $query = "INSERT INTO answer (discution_id, user_id, answer) VALUES (?, ?, ?)";

        $stmt = $this->connection->prepare($query);

        if(!$stmt) {
            $this->redirectWithMessage('query_error', "Error preparing query:  {$this->connection->error}");
        }

        $stmt->bind_param('iis', $discutionId, $_SESSION['user_id'], $answer);
        $result = $stmt->execute();

        if(!$result) {
            $this->redirectWithMessage('query_error', "Error registering user: {$stmt->error}");
        }
    
        $stmt->close();
        $this->updateDiscutionState($discutionId, $this->connection);      
    }*/

    public function createAnswer($discutionId, $answer) {
        $stmt = $this->executeQuery("INSERT INTO answer (discution_id, user_id, answer) VALUES (?, ?, ?)", "iis", "$_SERVER[HTTP_REFERER]", $discutionId, $_SESSION['user_id'], $answer);
        
        $stmt->close();
        $this->updateDiscutionState($discutionId, $this->connection);
    }

    /*private function updateDiscutionState($discutionId) {
        $query = "UPDATE discution SET have_answer = 1, advisor_id = ? WHERE id = ?";

        $stmt = $this->connection->prepare($query);

        if(!$stmt) {
            $this->redirectWithMessage('query_error', "Error preparing query:  {$this->connection->error}");
        }

        $stmt->bind_param('ii', $_SESSION['user_id'], $discutionId);
        $result = $stmt->execute();

        if(!$result) {
            $this->redirectWithMessage('query_error', "Error registering user: {$stmt->error}");
        }
        
        header('Location: ' . $_SERVER['HTTP_REFERER']);    
        $stmt->close();
        
    }*/

    private function updateDiscutionState($discutionId) {
        $stmt = $this->executeQuery("UPDATE discution SET have_answer = 1, advisor_id = ? WHERE id = ?", "ii", "$_SERVER[HTTP_REFERER]", $_SESSION['user_id'], $discutionId);
        
        header('Location: ' . $_SERVER['HTTP_REFERER']);    
        $stmt->close();
    }

   /* public function getAnswersFromDiscution($discutionId) {
        $query = "SELECT * FROM answer WHERE discution_id = ?";

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
        $questionUser = $this->getAnswerUser($row[0]['user_id']);
        $stmt->close();

        return [$row, $questionUser];
    }*/

    public function getAnswersFromDiscution($discutionId) {
        $stmt = $this->executeQuery("SELECT * FROM answer WHERE discution_id = ?", "i", "$_SERVER[HTTP_REFERER]", $discutionId);

        $result_set = $stmt->get_result();

        if($result_set->num_rows < 1) {
            return false;
        }
    
        $row = $result_set->fetch_all(MYSQLI_ASSOC); 
        $questionUser = $this->getAnswerUser($row[0]['user_id']);
        $stmt->close();

        return [$row, $questionUser];
    }

   /* public function getAnswerUser($userId) {
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
    }*/

    public function getAnswerUser($userId) {
        $stmt = $this->executeQuery("SELECT username, profile_image FROM user WHERE id = ?", "i", "$_SERVER[HTTP_REFERER]", $userId);

        $result_set = $stmt->get_result();

        if($result_set->num_rows < 1) {
            return false;
        }
 
        $row = $result_set->fetch_assoc(); 
        $stmt->close();
        return $row;
    }
}