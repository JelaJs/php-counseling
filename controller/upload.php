<?php

if(isset($_POST['submit'])) {

    require_once "../Classes/SessionConfig.php";
require_once "../Classes/User.php"; 

$session = new SessionConfig();
$user = new User($_FILES['file']);

$session->startSession();
$user->uploadImage();

}else {
    header("Location: ../index.php");
}