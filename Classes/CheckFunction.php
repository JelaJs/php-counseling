<?php

class CheckFunction {
    public function isAdvisorAndDontHaveAnswer($haveAnswer) {
        return $_SESSION['type'] === "advisor" && $haveAnswer == false;
    }

    public function isAdvisorAndAlreadyAnswered($haveAnswer, $advisorId) {
       return $_SESSION['type'] === "advisor" && $haveAnswer == true && $advisorId == $_SESSION['user_id'];
    }
}