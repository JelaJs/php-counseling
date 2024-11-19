<?php if($userDiscutions) : ?>
    <p class="mt-5">Your discutions:</p>
    <ul class="list-group">
    <?php foreach($userDiscutions as $userDiscution) : ?>
        <li class="list-group-item"><a class="navbar-brand" href="questions.php?discution_id=<?= $userDiscution['id']; ?>"><?= $userDiscution['topic']; ?></a></li>
    <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p class="mt-3">No discutions yet...</p>
<?php endif; ?>