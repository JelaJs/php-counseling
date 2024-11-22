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
        <form action="controller/registerController.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Exampl123">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email@email.com">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="*********">
            </div>
            <div class="mb-3">
                <label class="form-label">Type</label>
                <select name="type" class="form-select">
                    <option value="listener" default>Listener</option>
                    <option value="advisor">Advisor</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>

        <div>
            <?php require_once 'snippets/checkInputErrors.php'; ?>
            <?php require_once 'snippets/checkQueryErrors.php'; ?>
            <?php require_once 'snippets/checkUsernameQueryErrors.php'; ?>
            <?php require_once 'snippets/checkEmailQueryErrors.php'; ?>
        </div>
    </div>
<?php require_once "snippets/footer.php"; ?>