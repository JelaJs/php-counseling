<?php
require_once 'Classes/SessionConfig.php';

$session = new SessionConfig();
$session->startSession();

if(isset($_SESSION['user_id'])) {
    header("Location: index.php");
}
?>


<?php require_once "snippets/header.php"; ?>
    <?php require_once "snippets/navbar.php"; ?>

    <div class="container mt-4">
        <form action="controller/loginController.php" method="POST">
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
            <?php require_once 'snippets/checkInputErrors.php'; ?>
            <?php require_once 'snippets/checkQueryErrors.php'; ?>
        </div>
    </div>
<?php require_once "snippets/footer.php"; ?>