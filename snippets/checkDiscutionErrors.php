<?php if(isset($_SESSION['discution_error'])) :?>
    <p><?= $_SESSION['discution_error']; ?></p>
     <?php unset($_SESSION['discution_error']); ?>
<?php endif; ?>