<?php if(isset($allDiscutions)) : ?>
    <ul class="list-group">
        <?php foreach($allDiscutions as $discution) : ?>
            <li class="list-group-item w-75"><a class="navbar-brand" href="questions.php?discution_id=<?= $discution['id']; ?>"><?= $discution['topic']; ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p>No discutions yet...</p>
<?php endif; ?>