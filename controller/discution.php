<?php

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once "../Classes/SessionConfig.php";
    require_once "../Classes/Question.php";
    require_once "../Classes/Discution.php";

    $session = new SessionConfig();
    $discution = new Discution($_POST['discution_topic'], $_POST['question']);

    $session->startSession();
    $discution->createQuestionAndDiscution();

}else {
    header("Location: ../index.php");
}