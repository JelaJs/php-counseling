<?php if(CheckFunction::isAdvisorAndDontHaveAnswer($haveAnswer) || CheckFunction::isAdvisorAndAlreadyAnswered($haveAnswer, $advisorId)) : ?>
    <form action="controller/answerController.php" method="POST" class="mb-3">
        <input type="number" name="discution_id" value="<?= $discution_id; ?>" hidden>
        <div class="mb-3">
            <input type="text" name="answer" class="form-control" placeholder="Type your answer here">
        </div>
        <button class="btn btn-primary">Answer on question</button>
    </form>
    <?php require 'checkAnswerErrors.php'; ?>
<?php endif; ?>