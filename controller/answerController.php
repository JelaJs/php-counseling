<?php

if($_SERVER["REQUEST_METHOD"] !== 'POST') {
    header("Location: ../index.php");
}

require_once "../Classes/SessionConfig.php";
require_once "../Classes/UserDiscution.php";
require_once "../Classes/Answer.php";
require_once "../Classes/DataValidator.php";

$rediectUrl = "$_SERVER[HTTP_REFERER]";
$session = new SessionConfig();
$discution = new UserDiscution();
$answer = new Answer();

$session->startSession();

DataValidator::isInputValid('answer_error', $_POST['answer'], $rediectUrl);
DataValidator::isInputValid('answer_error', $_POST['discution_id'], $rediectUrl);

$discutionById = $discution->getDiscutionByDiscutionId($_POST['discution_id']);
$discutionHaveAnswer = $discutionById['have_answer'];
$advisorId = $discutionById['advisor_id'];

if($discutionHaveAnswer == false || ($discutionHaveAnswer == true && $advisorId == $_SESSION['user_id'])) {
    $answer->createAnswer($_POST['discution_id'], $_POST['answer']);
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    $_SESSION['answer_error'] = "You can only give answers in discussions that don’t have one yet, or in those where you’ve already answered.";
    die();
}
