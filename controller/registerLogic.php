<?php

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
}

require_once '../Classes/SessionConfig.php';
require_once "../Classes/Register.php";
    
$session = new SessionConfig();
$user = new Register($_POST['username'], $_POST['email'], $_POST['type'], $_POST['password']);

$session->startSession();
    
$user->isUserLoggedIn();
$user->registerUser();
