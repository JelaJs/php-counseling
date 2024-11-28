<?php

class DataValidator {
    public static function isAdvisorAndDontHaveAnswer($haveAnswer) {
        return $_SESSION['type'] === "advisor" && $haveAnswer == false;
    }

    public static function isAdvisorAndAlreadyAnswered($haveAnswer, $advisorId) {
       return $_SESSION['type'] === "advisor" && $haveAnswer == true && $advisorId == $_SESSION['user_id'];
    }

    public static function redirectWithMessage($errorName, $message, $location) {
        $_SESSION[$errorName] = $message;
        header("Location: $location");
        die();
    }

    public static function isUsernameFieldValid($username, $redirectUrl) {
        if(!isset($username) || empty($username)) {
            self::redirectWithMessage('input_error', 'Username can not be empty', $redirectUrl);
        }

        if(strlen($username) < 4) {
            self::redirectWithMessage('input_error', 'Username needs to be at least 4 charachters long', $redirectUrl);
        }

        if(strpos($username, ' ')) {
            self::redirectWithMessage('input_error', 'You can not use space in username field', $redirectUrl);
        }
    }

    public static function isTypeFieldValid($type, $redirectUrl) {
        if(!isset($type) || empty($type)) {
            self::redirectWithMessage('input_error', 'Type can not be empty', $redirectUrl);
        }

        if($type !== "listener" && $type !== "advisor") {
            self::redirectWithMessage('input_error', 'The type can be either listener or advisor', $redirectUrl);
        }
    }

    public static function isEmailFieldValid($email, $redirectUrl) {
        if(!isset($email) || empty($email)) {
            self::redirectWithMessage('input_error', 'Email can not be empty', $redirectUrl);
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            self::redirectWithMessage('input_error', 'Invalid Email format', $redirectUrl);
        }
    }

    public static function isPasswordFieldValid($password, $redirectUrl) {
        if(!isset($password) || empty($password)) {
            self::redirectWithMessage('input_error', 'Password can not be empty', $redirectUrl);
        }

        if(!preg_match('/^(?=.*[A-Z]).{6,}$/', $password)) {
            self::redirectWithMessage('input_error', 'Password needs to be at least 6 characters long and needs to have at least one big letter', $redirectUrl);
        }
    }

    public static function isInputValid($error, $input, $redirectUrl) {
        if(!isset($input)) {
            self::redirectWithMessage($error, 'You need to add text', $redirectUrl);
        }

        $trimmedInput= trim($input);
        if(empty($trimmedInput)) {
            self::redirectWithMessage($error, 'You need to add text', $redirectUrl);
        }
    }

    public static function isFileExist($file, $redirectUrl) {
        if($file['name'] == '') {
            self::redirectWithMessage('file_error', 'You need to add image', $redirectUrl);
        }
    } 
}