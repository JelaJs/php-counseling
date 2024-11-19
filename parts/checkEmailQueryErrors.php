<?php if(isset($_SESSION['email_query_error'])) :?>
    <p><?= $_SESSION['email_query_error']; ?></p>
    <?php unset($_SESSION['email_query_error']); ?>
<?php endif; ?>