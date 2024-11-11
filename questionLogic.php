<?php

if($_SERVER["REQUEST_METHOD"] === 'POST') {

    require_once "Classes/Database.php";
    require_once "Classes/UserDiscution.php";
    require_once "Classes/Question.php";

    $db = new Database();
    $discution = new UserDiscution();
    $question = new Question(); 
    
    $db->startSession();

    $userDiscutions = $discution->getUserDiscutions();
    $discutionById = $discution->getDiscutionByDiscutionId($_POST['discution_id']);
    
    $question->isInputValid($_POST['question']);
    $question->isInputValid($_POST['discution_id']);

    $isThisUserDisction = in_array($discutionById, $userDiscutions);

    if($isThisUserDisction) {
        $question->createQuestion($_SESSION['user_id'], $_POST['discution_id'], $_POST['question'], $db->connection);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    } else {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        $_SESSION['question_error'] = "You can ask questions only in, discussions that you are making.";
        die();
    }

} else {
    header("Location: index.php");
}