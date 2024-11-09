<?php

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once "Classes/Question.php";
    require_once "Classes/Discution.php";

    $discution = new Discution($_POST['discution_topic'], $_POST['question']);
    $discution->createQuestionAndDiscution();

}else {
    header("Location: index.php");
}