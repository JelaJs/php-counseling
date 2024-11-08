<?php

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once "Classes/Login.php";

    $user = new Login($_POST['email'], $_POST['password']);
    $user->loginUser();

} else {
    header("Location: index.php");
}