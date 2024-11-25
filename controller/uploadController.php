<?php

if(!isset($_POST['submit'])) {
    header("Location: ../index.php");
}

require_once "../Classes/SessionConfig.php";
require_once "../Classes/User/User.php"; 
require_once "../Classes/DataValidator.php";

$redirectUrl = '../index.php';
$session = new SessionConfig();
$user = new User();

$session->startSession();

DataValidator::isFileExist($_FILES['file'], $redirectUrl);

$user->setProfileImgInfo($_FILES['file']);


if(!$user->isExtensionAllowed()) {
    DataValidator::redirectWithMessage('file_error', 'You can not upload a file with this extension', $redirectUrl);  
}

if($user->errorExist()) {
    DataValidator::redirectWithMessage('file_error', 'There was an error uploading your imagen', $redirectUrl);  
}

if(!$user->isImageSizeCorrect()) {
    DataValidator::redirectWithMessage('file_error', 'Your image is too big', $redirectUrl);  
}

$user->uploadImage($_FILES['file']);
