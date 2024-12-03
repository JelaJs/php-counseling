<?php

require_once "../Classes/SessionConfig.php";
require_once "../Classes/DataValidator.php";
require_once "../Classes/UserDiscution.php";

$redirectUrl = '../index.php';

DataValidator::isInputValid("invalidId", $_POST['id'], $redirectUrl);

$session = new SessionConfig();
$discution = new UserDiscution();

$session->startSession();

$userDiscutions = $discution->getUserDiscutions();
$currentDiscution = $discution->getDiscutionByDiscutionId($_POST['id']);

$correctDiscution = in_array($currentDiscution, $userDiscutions);

if(!$correctDiscution) {
    DataValidator::redirectWithMessage('invalidId', "Invalid ID", $redirectUrl);
}

$discution->deleteDiscution($_POST['id']);

header("Location: $redirectUrl");
die();