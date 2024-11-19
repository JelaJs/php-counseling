<?php if(isset($_SESSION['username_query_error'])) :?>
    <p><?= $_SESSION['username_query_error']; ?></p>
    <?php unset($_SESSION['username_query_error']); ?>
<?php endif; ?>