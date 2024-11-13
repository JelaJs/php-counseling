<?php

require_once "../Classes/SessionConfig.php";

$session = new SessionConfig();
$session->startSession();


session_unset();
session_destroy();

header("Location: ../index.php");