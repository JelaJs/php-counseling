<?php

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
}

require_once '../Classes/DataValidator.php';
require_once '../Classes/SessionConfig.php';
require_once "../Classes/User/Register.php";
    
$redirectUrl = '../register.php';
$session = new SessionConfig();
$user = new Register();

$session->startSession();

if(isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
}

DataValidator::isUsernameFieldValid($_POST['username'], $redirectUrl);
DataValidator::isEmailFieldValid($_POST['email'], $redirectUrl);
DataValidator::isPasswordFieldValid($_POST['password'], $redirectUrl);
DataValidator::isTypeFieldValid($_POST['type'], $redirectUrl);

$isUsernameExist = $user->checkIfUsernameExist($_POST['username']);
if($isUsernameExist) {
    DataValidator::redirectWithMessage('input_error', 'User with this username already exist', $redirectUrl);
}

$isEmailExist = $user->checkIfEmailExist($_POST['email']);
if($isEmailExist) {
    DataValidator::redirectWithMessage('input_error', 'User with this email already exist', $redirectUrl);
}

$user->registerUser($_POST['username'], $_POST['email'], $_POST['password'], $_POST['type']);
