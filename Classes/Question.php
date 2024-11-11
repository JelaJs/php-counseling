<?php

class Question{
    public function createQuestion($userId, $discutionId, $question, $connection) {
        $query = "INSERT INTO question (user_id, question, discution_id) VALUES (?, ?, ?)";

        $stmt = $connection->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param('isi', $userId, $question, $discutionId);
    
            $result = $stmt->execute();
    
            if ($result) {
                return true;
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

    public function getQuestionsFromDiscution($connection, $discutionId) {
        $query = "SELECT * FROM question WHERE discution_id = ?";

        $stmt = $connection->prepare($query);
    
        if ($stmt) {
            $stmt->bind_param("i", $discutionId);
            $result = $stmt->execute();
    
            if ($result) {
                $result_set = $stmt->get_result();
    
                if ($result_set->num_rows > 0) {
                    $row = $result_set->fetch_all(MYSQLI_ASSOC); 
                    $questionUser = $this->getQuestionUser($connection, $row[0]['user_id']);
                    return [$row, $questionUser];
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

    public function getQuestionUser($connection, $userId) {
        $query = "SELECT username, profile_image FROM user WHERE id = ?";

        $stmt = $connection->prepare($query);
    
        if ($stmt) {
            $stmt->bind_param("i", $userId);
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