<?php

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
}

require_once '../Classes/SessionConfig.php';
require_once "../Classes/Login.php";

$session = new SessionConfig();
$user = new Login($_POST['email'], $_POST['password']);

$session->startSession();
$user->loginUser();