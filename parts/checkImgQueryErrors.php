<?php if(isset($_SESSION['img_query_error'])) : ?>
    <p><?= $_SESSION['img_query_error']; ?></p>
    <?php unset($_SESSION['img_query_error']); ?>
<?php endif ?>