<?php

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
}

require_once "../Classes/SessionConfig.php";
require_once "../Classes/Question.php";
require_once "../Classes/Discution.php";
require_once "../Classes/DataValidator.php";

$redirectUrl = '../index.php';
$session = new SessionConfig();
$discution = new Discution();

$session->startSession();

DataValidator::isInputValid('discution_error', $_POST['discution_topic'], $redirectUrl);
DataValidator::isInputValid('discution_error', $_POST['question'], $redirectUrl);

$discution->createQuestionAndDiscution($_POST['discution_topic'], $_POST['question']);

