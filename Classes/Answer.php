<?php

class Answer {
    public function isInputValid($input) {
        if(!isset($input)) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            $_SESSION['answer_error'] = "Inputs can't be empty";
            die();
        }

        $trimmedInput = trim($input);
        if($trimmedInput == '') {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            $_SESSION['answer_error'] = "Inputs can't be empty";
            die();
        }
    }

    public function createAnswer($discutionId, $answer, $connection) {
        $query = "INSERT INTO answer (discution_id, user_id, answer) VALUES (?, ?, ?)";

        $stmt = $connection->prepare($query);
    
        if ($stmt) {
            $stmt->bind_param('iis', $discutionId, $_SESSION['user_id'], $answer);
    
            $result = $stmt->execute();
    
            if ($result) {
                $this->updateDiscutionState($discutionId, $connection);
            } else {
                $_SESSION['query_error'] = "Error registering user: " . $stmt->error;
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                die();
            }
    
            $stmt->close();
        } else {
            $this->startSession();
            $_SESSION['query_error'] = "Error preparing query: " . $connection->error;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            die();
        }
    }

    private function updateDiscutionState($discutionId, $connection) {
        $query = "UPDATE discution SET have_answer = 1, advisor_id = ? WHERE id = ?";

        $stmt = $connection->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param('ii', $_SESSION['user_id'], $discutionId);
            
            $result = $stmt->execute();
            
            if ($result) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else {
                $_SESSION['query_error'] = "Error updating profile image: " . $stmt->error;
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                die();
            }
            
            $stmt->close();
        } else {
            $_SESSION['query_error'] = "Error preparing query: " . $connection->error;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            die();
        }
    }

    public function getAnswersFromDiscution($connection, $discutionId) {
        $query = "SELECT * FROM answer WHERE discution_id = ?";

        $stmt = $connection->prepare($query);
    
        if ($stmt) {
            $stmt->bind_param("i", $discutionId);
            $result = $stmt->execute();
    
            if ($result) {
                $result_set = $stmt->get_result();
    
                if ($result_set->num_rows > 0) {
                    $row = $result_set->fetch_all(MYSQLI_ASSOC); 
                    $questionUser = $this->getAnswerUser($connection, $row[0]['user_id']);
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

    public function getAnswerUser($connection, $userId) {
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
}