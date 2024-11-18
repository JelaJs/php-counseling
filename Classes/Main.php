<?php

require_once 'Database.php';

class Main extends Database {

    public function __construct() {

        parent::__construct();
    }

    protected function redirectWithMessage($errorName, $message)
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        $_SESSION[$errorName] = $message;
        die();
    }
}