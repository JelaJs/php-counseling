<?php if($userDiscutions) : ?>
    <p class="mt-5">Your discutions:</p>
    <ul class="list-group">
    <?php foreach($userDiscutions as $userDiscution) : ?>
        <li class="list-group-item">
            <a class="navbar-brand" href="questions.php?discution_id=<?= $userDiscution['id']; ?>"><?= $userDiscution['topic']; ?></a>
            <form action="controller/deleteDiscutionController.php" method="POST">
                <input type="hidden" name="id" value="<?= $userDiscution['id']; ?>">
                <button>Delete discution</button>
            </form>
            <a href="renameDiscution.php?id=<?= $userDiscution['id']; ?>">Rename</a>
        </li>
    <?php endforeach; ?>
    </ul>
    <?php if(isset($_POST['invalidId'])) : ?>
        <p><?= $_POST['invalidId']; ?></p>
        <?php unset($_POST['invalidId']); ?>
    <?php endif; ?>
<?php else : ?>
    <p class="mt-3">No discutions yet...</p>
<?php endif; ?>