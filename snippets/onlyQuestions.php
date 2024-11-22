<?php if(!isset($questionsAndAnswers)) : ?>
    <?php foreach($discutionQuestions as $question) : ?>
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <?php if($questionUser['profile_image']) : ?>
                        <img src="<?= $questionUser['profile_image']; ?>" class="rounded-circle me-2" style="width: 50px; height: 50px; object-fit: cover;">
                    <?php else : ?>
                        <img src="profile_images/default/default-avatar.png" class="rounded-circle me-2" style="width: 50px; height: 50px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="d-flex justify-content-between w-100">
                        <p class="fw-bold mb-0"><?= $questionUser['username']; ?></p>
                        <p class="text-muted mb-0"><?= date("d/m/Y", strtotime($question['created_at'])); ?></p>
                    </div>
                </div>
                <p class="mb-0"><?= $question['question']; ?></p>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>