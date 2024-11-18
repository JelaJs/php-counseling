<?php if(isset($questionsAndAnswers)) : ?>
    <?php foreach($questionsAndAnswers as $arr) : ?>
        <?php require "loadQuestions.php"; ?>
        <?php require "loadAnswers.php"; ?>
    <?php endforeach; ?>
<?php endif; ?>