<?php
require_once "Main.php";

class Answer extends Main{

    public function __construct() {

        parent::__construct();
    }

    public function isInputValid($input) {
        if(!isset($input)) {
            $this->redirectWithMessage('answer_error', "Inputs can't be empty");
        }

        $trimmedInput = trim($input);
        if($trimmedInput == '') {
            $this->redirectWithMessage('answer_error', "Inputs can't be empty");
        }
    }

    public function createAnswer($discutionId, $answer) {
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
    }

    private function updateDiscutionState($discutionId) {
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
        
    }

    public function getAnswersFromDiscution($discutionId) {
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
    }

    public function getAnswerUser($userId) {
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
}