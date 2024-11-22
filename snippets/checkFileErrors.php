<?php if(isset($_SESSION['file_error'])) : ?>
    <p><?= $_SESSION['file_error']; ?></p>
    <?php unset($_SESSION['file_error']); ?>
<?php endif ?>