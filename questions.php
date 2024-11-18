<?php

if(!isset($_GET['discution_id']) || empty($_GET['discution_id'])) {
    die("Id is not set");
}

require_once "Classes/SessionConfig.php";
require_once "Classes/UserDiscution.php";
require_once "Classes/Question.php";
require_once "Classes/Answer.php";

$discution_id = $_GET['discution_id'];

$session = new SessionConfig();
$discution = new UserDiscution();
$question = new Question();
$answer = new Answer();

$discutionById = $discution->getDiscutionByDiscutionId($discution_id);
$haveAnswer = $discutionById['have_answer'];
$advisorId = $discutionById['advisor_id'];

$discutionQuestionsAndUser = $question->getQuestionsFromDiscution($discution_id);
$discutionQuestions = $discutionQuestionsAndUser[0];
$questionUser = $discutionQuestionsAndUser[1];

$discutionAnswersAndUser = $answer->getAnswersFromDiscution($discution_id);
if($discutionAnswersAndUser) {
    $discutionAnswers = $discutionAnswersAndUser[0];
    $answerUser = $discutionAnswersAndUser[1];

    $questionsAndAnswers = $discution->mergeAndSortQuestionsAndAnswers($discutionQuestions, $discutionAnswers);
}

$session->startSession();
?>

<?php require_once 'parts/header.php'; ?>
    <?php require_once "parts/navbar.php"; ?>
    <div class="container mt-3">
        <?php require_once 'parts/questionsAndAnswers.php'; ?>
        <?php require_once 'parts/onlyQuestions.php'; ?>
        <?php require "parts/checkQueryErrors.php"; ?>
    
    
        <?php if(isset($_SESSION['user_id'])) : ?>
            <?php require_once 'parts/questionForm.php'; ?>

            <?php require_once 'parts/answerForm.php'; ?>
        <?php endif; ?>
    </div>
<?php require_once "parts/footer.php"; ?>