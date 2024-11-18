<?php if(isset($_SESSION['query_error'])) : ?>
    <p><?= $_SESSION['query_error']; ?></p>
    <?php unset($_SESSION['query_error']); ?>
<?php endif; ?>