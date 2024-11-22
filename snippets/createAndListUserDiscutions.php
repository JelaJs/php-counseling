<?php if(isset($type) && $type === 'listener') : ?>
    <form action="controller/discutionController.php" method="POST" class="mt-5">
        <div class="mb-3">
            <label class="form-label">Discution Topic</label>
            <input type="text" name="discution_topic" class="form-control" placeholder="E.g. Programming">
            </div>
            <div class="mb-3">
            <label class="form-label">Question</label>
            <textarea name="question" class="form-control" rows="3" placeholder="Your question"></textarea>
        </div>
        <button class="btn btn-primary mt-1">Make Discution</button>
    </form>
        <?php require 'checkDiscutionErrors.php'; ?>
        <?php require 'checkQueryErrors.php'; ?>
        <?php require 'listUserDiscutions.php'; ?>
<?php endif; ?>