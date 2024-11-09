<?php

class Question{
    public function createQuestion($userId, $discutionId, $question, $connection) {
        $query = "INSERT INTO question (user_id, question, discution_id) VALUES (?, ?, ?)";

        $stmt = $connection->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param('isi', $userId, $question, $discutionId);
    
            $result = $stmt->execute();
    
            if ($result) {
                header("Location: index.php");
            } else {
                $_SESSION['query_error'] = "Error registering user: " . $stmt->error;
                header("Location: register.php");
                die();
            }
    
            $stmt->close();
        } else {
            $this->startSession();
            $_SESSION['query_error'] = "Error preparing query: " . $this->connection->error;
            header("Location: register.php");
            die();
        }
    }   
}