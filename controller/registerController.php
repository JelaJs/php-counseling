<?php

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
}

if(isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
}

require_once '../Classes/CheckFunction.php';
require_once '../Classes/SessionConfig.php';
require_once "../Classes/User/Register.php";
    
$redirectUrl = '../register.php';
$session = new SessionConfig();
$user = new Register();

$session->startSession();

//check inputs before sending
CheckFunction::isUsernameFieldValid($_POST['username'], $redirectUrl);
CheckFunction::isEmailFieldValid($_POST['email'], $redirectUrl);
CheckFunction::isPasswordFieldValid($_POST['password'], $redirectUrl);
CheckFunction::isTypeFieldValid($_POST['type'], $redirectUrl);

$isUsernameExist = $user->checkIfUsernameExist($_POST['username']);
if($isUsernameExist) {
    CheckFunction::redirectWithMessage('input_error', 'User with this username already exist', $redirectUrl);
}

$isEmailExist = $user->checkIfEmailExist($_POST['email']);
if($isEmailExist) {
    CheckFunction::redirectWithMessage('input_error', 'User with this email already exist', $redirectUrl);
}

$user->registerUser($_POST['username'], $_POST['email'], $_POST['password'], $_POST['type']);
