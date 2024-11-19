<?php if(isset($profileImage) && $profileImage == '') : ?>
    <img src="profile_images/default/default-avatar.png" class="card-img-top" alt="default profile picture">
<?php endif; ?>
<?php if(isset($profileImage) && $profileImage !== '') : ?>
    <img src="<?= $profileImage; ?>" class="card-img-top" alt="profile image">
<?php endif; ?>