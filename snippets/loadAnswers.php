<?php if(isset($arr['answer'])) :?>
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <?php if($answerUser['profile_image']) : ?>
                    <img src="<?= $answerUser['profile_image']; ?>" class="rounded-circle me-2" style="width: 50px; height: 50px; object-fit: cover;">
                <?php else : ?>
                    <img src="profile_images/default/default-avatar.png" class="rounded-circle me-2" style="width: 50px; height: 50px; object-fit: cover;">
                <?php endif; ?>
                <div class="d-flex justify-content-between w-100">
                    <p class="fw-bold mb-0"><?= $answerUser['username']; ?></p>
                    <p class="text-muted mb-0"><?= date("d/m/Y", strtotime($arr['created_at'])); ?></p>
                </div>
            </div>
            <p class="mb-0"><?= $arr['answer']; ?></p>
        </div>
    </div>
<?php endif; ?>