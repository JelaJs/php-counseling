<?php

if($_SERVER["REQUEST_METHOD"] === 'POST') {
    require_once "Classes/Database.php";
    require_once "Classes/UserDiscution.php";
    require_once "Classes/Answer.php";

    $db = new Database();
    $discution = new UserDiscution();
    $answer = new Answer();

    $db->startSession();

    $discutionById = $discution->getDiscutionByDiscutionId($_POST['discution_id']);
    $discutionHaveAnswer = $discutionById['have_answer'];
    $advisorId = $discutionById['advisor_id'];

    $answer->isInputValid($_POST['answer']);
    $answer->isInputValid($_POST['discution_id']);

    if($discutionHaveAnswer == false || ($discutionHaveAnswer == true && $advisorId == $_SESSION['user_id'])) {
        $answer->createAnswer($_POST['discution_id'], $_POST['answer'], $db->connection);
    }
}else {
    header("Location: index.php");
}