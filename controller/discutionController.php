<?php

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
}

require_once "../Classes/SessionConfig.php";
require_once "../Classes/Question.php";
require_once "../Classes/Discution.php";

$session = new SessionConfig();
$discution = new Discution();

$session->startSession();
$discution->createQuestionAndDiscution($_POST['discution_topic'], $_POST['question']);

