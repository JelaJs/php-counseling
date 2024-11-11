<?php

require_once "Classes/SessionConfig.php";
require_once "Classes/UserDiscution.php";

$discution = new UserDiscution();
$session = new SessionConfig();
$session->startSession();

if(isset($_GET['success_register']) && isset($_SESSION['success_register'])) {
    echo $_SESSION['success_register'];
    unset($_SESSION['success_register']);
}

$allDiscutions = $discution->getAllDiscutions();

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    $profileImage = $_SESSION['profile_image'];
    $type = $_SESSION['type'];

    $userDiscutions = $discution->getUserDiscutions();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <?php require_once "navbar.php"; ?>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-3">
                <?php if(isset($_SESSION['user_id'])) : ?>
                <div class="card" style="width: 15rem;">
                    <?php if(isset($profileImage) && $profileImage == '') : ?>
                    <img src="profile_images/default/default-avatar.png" class="card-img-top" alt="default profile picture">
                    <?php endif; ?>
                    <?php if(isset($profileImage) && $profileImage !== '') : ?>
                        <img src="<?= $profileImage; ?>" class="card-img-top" alt="default profile picture">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= $username; ?></h5>
                        <form action="upload.php" method="POST" enctype="multipart/form-data">
                            <input type="file" name="file" class="btn p-0">
                            <button type="submit" name="submit" class="btn btn-primary mt-1">Upload Image</button>
                        </form>
                    </div>
                    <?php if(isset($_SESSION['file_error'])) : ?>
                        <p><?= $_SESSION['file_error']; ?></p>
                        <?php unset($_SESSION['file_error']); ?>
                    <?php endif ?>
                </div>
                    <?php if(isset($type) && $type === 'listener') : ?>
                    <form action="discution.php" method="POST" class="mt-5">
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
                        <?php if(isset($_SESSION['discution_error'])) :?>
                            <p><?= $_SESSION['discution_error']; ?></p>
                            <?php unset($_SESSION['discution_error']); ?>
                        <?php endif; ?>
                        <?php if($userDiscutions) : ?>
                            <p class="mt-5">Tour discutions:</p>
                            <ul class="list-group">
                            <?php foreach($userDiscutions as $userDiscution) : ?>
                                <li class="list-group-item"><a class="navbar-brand" href="questions.php?discution_id=<?= $userDiscution['id']; ?>"><?= $userDiscution['topic']; ?></a></li>
                            <?php endforeach; ?>
                            </ul>
                        <?php else : ?>
                            <p class="mt-3">No discutions yet...</p>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="col-md-9 ps-5">
                <?php if(isset($allDiscutions)) : ?>
                    <ul class="list-group">
                        <?php foreach($allDiscutions as $discution) : ?>
                            <li class="list-group-item w-75"><a class="navbar-brand" href="questions.php?discution_id=<?= $discution['id']; ?>"><?= $discution['topic']; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p>No discutions yet...</p>
                <?php endif; ?>
            </div>
        </div>
        
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>