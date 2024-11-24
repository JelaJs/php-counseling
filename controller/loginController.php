<?php

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
}

if(isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
}

require_once '../Classes/CheckFunction.php';
require_once '../Classes/SessionConfig.php';
require_once "../Classes/User/Login.php";

$redirectUrl = '../login.php';
$session = new SessionConfig();
$user = new Login();

$session->startSession();

CheckFunction::isEmailFieldValid($_POST['email'], $redirectUrl);
CheckFunction::isPasswordFieldValid($_POST['password'], $redirectUrl);

$isEmailExist = $user->emailExist($_POST['email']);
if(!$isEmailExist) {
    CheckFunction::redirectWithMessage('input_error', 'There is no user with this email', $redirectUrl);
}

$isPasswordValid = $user->isPasswordValid($_POST['email'], $_POST['password']);
if(!$isPasswordValid) {
    CheckFunction::redirectWithMessage('input_error', 'Incorect password', $redirectUrl);
}

$user->loginUser($_POST['email']);