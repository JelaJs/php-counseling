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

<?php require_once "snippets/header.php"; ?>
    <?php require_once "snippets/navbar.php"; ?>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-3">
                <?php if(isset($_SESSION['user_id'])) : ?>
                    <?php require_once 'snippets/userCard.php'; ?>
                    <?php require_once 'snippets/createAndListUserDiscutions.php'; ?>
                <?php endif; ?>
            </div>
            <div class="col-md-9 ps-5">
              <?php require_once 'snippets/listAllDiscutions.php'; ?>
            </div>
        </div>
        
    </div>
<?php require_once "snippets/footer.php"; ?>