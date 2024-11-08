<?php

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once "Classes/Register.php";
    
    $user = new Register($_POST['username'], $_POST['email'], $_POST['type'], $_POST['password']);
    
    $user->isUserLoggedIn();
    $user->registerUser();

} else {
    header("Location: index.php");
}