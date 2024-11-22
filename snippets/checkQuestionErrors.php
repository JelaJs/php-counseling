<?php if(isset($_SESSION['question_error'])) : ?>
    <p><?= $_SESSION['question_error']; ?></p>
    <?php unset($_SESSION['question_error']); ?>
<?php endif; ?>