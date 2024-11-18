<?php if($discutionQuestions[0]['user_id'] === $_SESSION['user_id']) : ?>
    <form action="controller/questionLogic.php" method="POST" class="mb-3">
        <input type="number" name="discution_id" value="<?= $discution_id; ?>" hidden>
        <div class="mb-3">
            <input type="text" name="question" class="form-control" placeholder="Type your question here" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Question</button>
    </form>
    <?php require 'checkQuestionErrors.php'; ?>
<?php endif; ?>