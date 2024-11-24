<?php

require_once "Database.php";

class Discution extends Database {

    public function __construct() {

        parent::__construct();
    }

    public function createQuestionAndDiscution($discutionTopic, $discutionQuestion) {
        $stmt = $this->executeQuery("INSERT INTO discution (user_id, topic) VALUES (?, ?)", "is", "../index.php", $_SESSION['user_id'], $discutionTopic);

        $discutionId = $stmt->insert_id;
        $stmt->close();
    
        $question = new Question();
        $question->createQuestion($_SESSION['user_id'], $discutionId, $discutionQuestion);

        header("Location: ../index.php");
        die();
    }
}