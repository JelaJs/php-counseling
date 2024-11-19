<?php if(isset($_SESSION['input_error'])) :?>
    <p><?= $_SESSION['input_error']; ?></p>
    <?php unset($_SESSION['input_error']); ?>
<?php endif; ?>