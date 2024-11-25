<?php

if($_SERVER["REQUEST_METHOD"] !== 'POST') {
    header("Location: ../index.php");
}

require_once "../Classes/SessionConfig.php";
require_once "../Classes/UserDiscution.php";
require_once "../Classes/Question.php";
require_once "../Classes/DataValidator.php";

$rediectUrl = "$_SERVER[HTTP_REFERER]";
$session = new SessionConfig();
$discution = new UserDiscution();
$question = new Question(); 
    
$session->startSession();

DataValidator::isInputValid('question_error', $_POST['question'], $rediectUrl);
DataValidator::isInputValid('question_error', $_POST['discution_id'], $rediectUrl);

$userDiscutions = $discution->getUserDiscutions();
$discutionById = $discution->getDiscutionByDiscutionId($_POST['discution_id']);
    

$isThisUserDisction = in_array($discutionById, $userDiscutions);

if($isThisUserDisction) {
    $question->createQuestion($_SESSION['user_id'], $_POST['discution_id'], $_POST['question']);
    
} else {
    $_SESSION['question_error'] = "You can ask questions only in, discussions that you are making.";
}

header('Location: ' . $_SERVER['HTTP_REFERER']);