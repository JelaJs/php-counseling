<?php

if(isset($_POST['submit'])) {

require_once "Classes/User.php"; 

$user = new User($_FILES['file']);

$user->uploadImage();

}else {
    header("Location: index.php");
}