<?php
require_once 'Classes/SessionConfig.php';

$session = new SessionConfig();
$session->startSession();

if(isset($_SESSION['user_id'])) {
    header("Location: index.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
    <?php require_once "navbar.php"; ?>

    <div class="container mt-4">
        <form action="controller/loginLogic.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email@email.com">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="*********">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <div>
            <?php if(isset($_SESSION['input_error'])) :?>
                <p><?= $_SESSION['input_error']; ?></p>
                <?php unset($_SESSION['input_error']); ?>
            <?php endif; ?>

            <?php if(isset($_SESSION['query_error'])) :?>
                <p><?= $_SESSION['query_error']; ?></p>
                <?php unset($_SESSION['query_error']); ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>