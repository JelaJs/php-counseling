<?php if(isset($_SESSION['answer_error'])) : ?>
    <p><?= $_SESSION['answer_error']; ?></p>
    <?php unset($_SESSION['answer_error']); ?>
<?php endif; ?>