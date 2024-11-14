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

if($discutionQuestionsAndUser) {
    $discutionQuestions = $discutionQuestionsAndUser[0];
    $questionUser = $discutionQuestionsAndUser[1];
}

$discutionAnswersAndUser = $answer->getAnswersFromDiscution($discution_id);
if($discutionAnswersAndUser) {
    $discutionAnswers = $discutionAnswersAndUser[0];
    $answerUser = $discutionAnswersAndUser[1];
}

//$mergedArrays = array_merge($discutionQuestions, $discutionAnswers);

$session->startSession();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <?php require_once "navbar.php"; ?>
    <div class="container mt-3">
    <?php if($discutionQuestionsAndUser) : ?>
        <?php foreach($discutionQuestions as $question) : ?>
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <?php if($questionUser['profile_image']) : ?>
                        <img src="<?= $questionUser['profile_image']; ?>" class="rounded-circle me-2" style="width: 50px; height: 50px; object-fit: cover;">
                    <?php else : ?>
                        <img src="profile_images/default/default-avatar.png" class="rounded-circle me-2" style="width: 50px; height: 50px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="d-flex justify-content-between w-100">
                        <p class="fw-bold mb-0"><?= $questionUser['username']; ?></p>
                        <p class="text-muted mb-0"><?= date("d/m/Y", strtotime($question['created_at'])); ?></p>
                    </div>
                </div>
                <p class="mb-0"><?= $question['question']; ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if($discutionAnswersAndUser) : ?>
        <?php foreach($discutionAnswers as $answer) : ?>
            <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <?php if($answerUser['profile_image']) : ?>
                        <img src="<?= $answerUser['profile_image']; ?>" class="rounded-circle me-2" style="width: 50px; height: 50px; object-fit: cover;">
                    <?php else : ?>
                        <img src="profile_images/default/default-avatar.png" class="rounded-circle me-2" style="width: 50px; height: 50px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="d-flex justify-content-between w-100">
                        <p class="fw-bold mb-0"><?= $answerUser['username']; ?></p>
                        <p class="text-muted mb-0"><?= date("d/m/Y", strtotime($answer['created_at'])); ?></p>
                    </div>
                </div>
                <p class="mb-0"><?= $answer['answer']; ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if(isset($_SESSION['query_error'])) : ?>
        <p><?= $_SESSION['query_error']; ?></p>
        <?php unset($_SESSION['query_error']); ?>
    <?php endif; ?>
    
    
    <?php if(isset($_SESSION['user_id'])) : ?>
        <?php if($discutionQuestions[0]['user_id'] === $_SESSION['user_id']) : ?>
            <form action="controller/questionLogic.php" method="POST" class="mb-3">
                <input type="number" name="discution_id" value="<?= $discution_id; ?>" hidden>
                <div class="mb-3">
                    <input type="text" name="question" class="form-control" placeholder="Type your question here" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Question</button>
            </form>
            <?php if(isset($_SESSION['question_error'])) : ?>
                <p><?= $_SESSION['question_error']; ?></p>
                <?php unset($_SESSION['question_error']); ?>
            <?php endif; ?>
        <?php endif; ?>

        <?php if(($_SESSION['type'] === "advisor" && $haveAnswer == false) || ($_SESSION['type'] === "advisor" && $haveAnswer == true && $advisorId == $_SESSION['user_id'])) : ?>
            <form action="controller/answerLogic.php" method="POST" class="mb-3">
                <input type="number" name="discution_id" value="<?= $discution_id; ?>" hidden>
                <div class="mb-3">
                    <input type="text" name="answer" class="form-control" placeholder="Type your answer here">
                </div>
                <button class="btn btn-primary">Answer on question</button>
            </form>
            <?php if(isset($_SESSION['answer_error'])) : ?>
                <p><?= $_SESSION['answer_error']; ?></p>
                <?php unset($_SESSION['answer_error']); ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
    </div>
</body>
</html>