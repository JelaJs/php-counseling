<?php

require_once "Database.php";

class Discution extends Database {
    private $discutionId;

    public function __construct() {

        parent::__construct();
    }

    private function areInputsValid($discutionTopic, $discutionQuestion) {
        $this->isInputValid($discutionTopic);
        $this->isInputValid($discutionQuestion);

        return true;
    }

    private function isInputValid($input) {
        if(!isset($input)) {
            $_SESSION['discution_error'] = "You need to add text";
            header("Location: ../index.php");
            die();
        }

        $trimmedInput= trim($input);
        if(empty($trimmedInput)) {
            $_SESSION['discution_error'] = "You need to add text";
            header("Location: ../index.php");
            die();
        }
    }

    public function createQuestionAndDiscution($discutionTopic, $discutionQuestion) {

        $this->areInputsValid($discutionTopic, $discutionQuestion);
        $this->createDiscution($discutionTopic, $discutionQuestion);
    }

    private function createDiscution($discutionTopic, $discutionQuestion) {
        $query = "INSERT INTO discution (user_id, topic) VALUES (?, ?)";

        $stmt = $this->connection->prepare($query);

        if(!$stmt) {
            $_SESSION['query_error'] = "Error preparing query: " . $this->connection->error;
            header("Location: ../index.php");
            die();
        }

        $stmt->bind_param('is', $_SESSION['user_id'], $discutionTopic);
        $result = $stmt->execute();

        if(!$result) {
            $_SESSION['query_error'] = "Error registering user: " . $stmt->error;
            header("Location: ../index.php");
            die();
        }

        $this->discutionId = $stmt->insert_id;
        $stmt->close();
    
        $question = new Question();
        $question->createQuestion($_SESSION['user_id'], $this->discutionId, $discutionQuestion);

        header("Location: ../index.php");
        die();
    }
}