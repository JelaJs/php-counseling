<?php

require_once "Database.php";

class Discution extends Database {
    private $discutionTopic;
    private $question;
    private $discutionId;
    //by default question don't have ansver so I passed 0
    private $discutionCreatedDefault = 0;

    public function __construct($discutionTopic, $question) {
        $this->discutionTopic = $discutionTopic;
        $this->question = $question;

        parent::__construct();
    }

    private function areInputsValid() {
        $this->isInputValid($this->discutionTopic);
        $this->isInputValid($this->question);

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

    public function createQuestionAndDiscution() {

        $this->areInputsValid();
        $this->createDiscution();
    }

    private function createDiscution() {
        $query = "INSERT INTO discution (user_id, topic, have_answer) VALUES (?, ?, ?)";

        $stmt = $this->connection->prepare($query);

        if(!$stmt) {
            $_SESSION['query_error'] = "Error preparing query: " . $this->connection->error;
            header("Location: ../index.php");
            die();
        }

        $stmt->bind_param('isi', $_SESSION['user_id'], $this->discutionTopic, $this->discutionCreatedDefault);
        $result = $stmt->execute();

        if(!$result) {
            $_SESSION['query_error'] = "Error registering user: " . $stmt->error;
            header("Location: ../index.php");
            die();
        }

        $this->discutionId = $stmt->insert_id;
        $stmt->close();
    
        $question = new Question();
        $question->createQuestion($_SESSION['user_id'], $this->discutionId, $this->question);

        header("Location: ../index.php");
        die();
    }
}