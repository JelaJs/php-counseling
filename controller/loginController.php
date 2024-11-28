<?php

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
}

require_once '../Classes/DataValidator.php';
require_once '../Classes/SessionConfig.php';
require_once "../Classes/User/Login.php";

$redirectUrl = '../login.php';
$session = new SessionConfig();
$user = new Login();

$session->startSession();

if(isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
}

DataValidator::isEmailFieldValid($_POST['email'], $redirectUrl);
DataValidator::isPasswordFieldValid($_POST['password'], $redirectUrl);

$isEmailExist = $user->emailExist($_POST['email']);
if(!$isEmailExist) {
    DataValidator::redirectWithMessage('input_error', 'There is no user with this email', $redirectUrl);
}

$isPasswordValid = $user->isPasswordValid($_POST['email'], $_POST['password']);
if(!$isPasswordValid) {
    DataValidator::redirectWithMessage('input_error', 'Incorect password', $redirectUrl);
}

$user->loginUser($_POST['email']);